<?php

$installer = $this;

$installer->startSetup();
/**
 * Create table 'customrolepermissions/rule'
 */
$tableInstaller = $installer->getTable('customrolepermissions/rule');

$installer->getConnection()->dropTable($tableInstaller);

$table = $installer->getConnection()
        ->newTable($tableInstaller)
        ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'auto_increment' => true,
                ), 'rule Id')
        ->addColumn('role_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false
        ), 'role_id')
        ->addColumn('scope_websites', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
                ), 'scope_websites')
    ->addColumn('scope_storeviews', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
    ), 'scope_storeviews')
    ->addForeignKey($installer->getFkName('customrolepermissions/rule', 'role_id', 'admin/role', 'role_id'),
        'role_id', $installer->getTable('admin/role'), 'role_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Custom Role Permissions');
$installer->getConnection()->createTable($table);

$installer->endSetup();
