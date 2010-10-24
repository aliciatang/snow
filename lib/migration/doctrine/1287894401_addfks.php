<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Addfks extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('account', 'account_user_id_sf_guard_user_id', array(
             'name' => 'account_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('account_security', 'account_security_account_id_account_id', array(
             'name' => 'account_security_account_id_account_id',
             'local' => 'account_id',
             'foreign' => 'id',
             'foreignTable' => 'account',
             ));
        $this->createForeignKey('account_security', 'account_security_security_id_security_id', array(
             'name' => 'account_security_security_id_security_id',
             'local' => 'security_id',
             'foreign' => 'id',
             'foreignTable' => 'security',
             ));
        $this->createForeignKey('price', 'price_security_id_security_id', array(
             'name' => 'price_security_id_security_id',
             'local' => 'security_id',
             'foreign' => 'id',
             'foreignTable' => 'security',
             ));
        $this->createForeignKey('price_alert', 'price_alert_alert_id_alert_id', array(
             'name' => 'price_alert_alert_id_alert_id',
             'local' => 'alert_id',
             'foreign' => 'id',
             'foreignTable' => 'alert',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('price_alert', 'price_alert_security_id_security_id', array(
             'name' => 'price_alert_security_id_security_id',
             'local' => 'security_id',
             'foreign' => 'id',
             'foreignTable' => 'security',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('price_alert', 'price_alert_user_id_sf_guard_user_id', array(
             'name' => 'price_alert_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'cascade',
             ));
        $this->createForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_forgot_password_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_group_permission_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_group_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_remember_key_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_group_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_user_group_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_permission_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_user_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('transaction', 'transaction_prev_tran_transaction_id', array(
             'name' => 'transaction_prev_tran_transaction_id',
             'local' => 'prev_tran',
             'foreign' => 'id',
             'foreignTable' => 'transaction',
             ));
        $this->createForeignKey('transaction', 'transaction_account_id_account_id', array(
             'name' => 'transaction_account_id_account_id',
             'local' => 'account_id',
             'foreign' => 'id',
             'foreignTable' => 'account',
             ));
        $this->createForeignKey('transaction', 'transaction_action_id_action_id', array(
             'name' => 'transaction_action_id_action_id',
             'local' => 'action_id',
             'foreign' => 'id',
             'foreignTable' => 'action',
             ));
        $this->createForeignKey('transaction', 'transaction_security_id_security_id', array(
             'name' => 'transaction_security_id_security_id',
             'local' => 'security_id',
             'foreign' => 'id',
             'foreignTable' => 'security',
             ));
        $this->createForeignKey('transaction', 'transaction_synthetic_id_synthetic_id', array(
             'name' => 'transaction_synthetic_id_synthetic_id',
             'local' => 'synthetic_id',
             'foreign' => 'id',
             'foreignTable' => 'synthetic',
             ));
        $this->createForeignKey('user_login_history', 'user_login_history_user_id_sf_guard_user_id', array(
             'name' => 'user_login_history_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             ));
    }

    public function down()
    {
        $this->dropForeignKey('account', 'account_user_id_sf_guard_user_id');
        $this->dropForeignKey('account_security', 'account_security_account_id_account_id');
        $this->dropForeignKey('account_security', 'account_security_security_id_security_id');
        $this->dropForeignKey('price', 'price_security_id_security_id');
        $this->dropForeignKey('price_alert', 'price_alert_alert_id_alert_id');
        $this->dropForeignKey('price_alert', 'price_alert_security_id_security_id');
        $this->dropForeignKey('price_alert', 'price_alert_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('transaction', 'transaction_prev_tran_transaction_id');
        $this->dropForeignKey('transaction', 'transaction_account_id_account_id');
        $this->dropForeignKey('transaction', 'transaction_action_id_action_id');
        $this->dropForeignKey('transaction', 'transaction_security_id_security_id');
        $this->dropForeignKey('transaction', 'transaction_synthetic_id_synthetic_id');
        $this->dropForeignKey('user_login_history', 'user_login_history_user_id_sf_guard_user_id');
    }
}