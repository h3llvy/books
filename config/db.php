<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=database',
    'username' => 'root',
    'password' => 'root_password',
    'charset' => 'utf8',

    'enableProfiling' => true,
    'enableLogging' => true,

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];