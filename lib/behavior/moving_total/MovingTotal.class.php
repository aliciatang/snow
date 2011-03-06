<?php
class MovingTotal extends Doctrine_Template
{
  protected $_options = array();

  public function setTableDefinition()
  {
    foreach($this->_options as $name => $rules)
    {
      if(!$rules['column'])
      {
        throw Exception("Must define a column in order to use the moving total behavior");
      }
      if(!$rules['totalColumn'])
      {
        $this->_options[$name]['totalColumn']='total_'.$rules['column'];
      }
      $columnName = $rules['column'];
      $totalColumn = $this->_options[$name]['totalColumn'];
      $this->_options[$name]['className'] = $this->_table->getOption('name');
      $definition = $this->_table->getColumnDefinition($columnName);
      $this->_table->setColumn($totalColumn, $definition['type'] , $definition['length'],$definition );
    }
    $this->addListener(new MovingTotalListener($this->_options));
  }
  public function setUp()
  {
  }
}
