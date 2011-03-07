<?php
class MovingTotalListener extends Doctrine_Record_Listener
{
  protected $_options= array();
  public function __construct(array $options)
  {
    $this->_options = $options;
  }
  public function postInsert(Doctrine_Event $event)
  {
    $invoker = $event->getInvoker();
    foreach($this->_options as $name => $options)
    {
      $table = Doctrine::getTable($options['className']);
      // get the previous moving total
      $q = $table->createQuery()
                    ->orderBy($options['orderBy']." DESC")
                    ->addOrderBy('id DESC')
                    ->where($options['orderBy']." <= ?",$invoker->$options['orderBy'])
                    ->andWhere('id <> ?', $invoker->id)
                    ;
      if(isset($options['groupBy']))
      {
        foreach($options['groupBy'] as $c)
        {
          $q = $q->andWhere($c." = ?",$invoker->$c);
        }
      }
      if( $prev = $q->fetchOne())
      {
        $prev = $prev->$options['totalColumn'];
      }
      else
      {
        $prev = 0;
      }
      // set current moving total
      $value = $invoker->$options['column'];
      if(isset($options['condition']))
      {
        $ret = in_array($invoker->$options['condition']['column'],$options['condition']['values']);
        $value = $ret ? $value: 0;
      }
      $invoker->$options['totalColumn'] = $prev + $value;
      $invoker->save();
      // update the succeeding moving totals if any
      if($value == 0) continue;
      $update = $options['totalColumn']." + '".$value."' ";
      $q = $table
        ->createQuery()
        ->update()
        ->set($options['totalColumn'], $update);
      if(isset($options['orderBy']))
      {
        $q = $q->where($options['orderBy']." > ? ",$invoker->$options['orderBy']);
      }
      if(isset($options['groupBy']))
      {
        foreach($options['groupBy'] as $c)
        {
          $q = $q->andWhere($c." = ?",$invoker->$c);
        }
      }
      $q->execute();
    }
  }
}
