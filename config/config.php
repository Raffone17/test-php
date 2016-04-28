<?php

/**
* Configuration Variables
* The variables are loaded form a hidden file, called .env, where are set all the
* configuration.
*/

$configs = parse_ini_file( ROOT . DS . '.env');

define ('DEVELOPMENT_ENVIRONMENT',$configs['develope_env']);

define('DB_NAME', $configs['dbname']);
define('DB_USER', $configs['username']);
define('DB_PASSWORD', $configs['password']);
define('DB_HOST', $configs['host']);
define('APP_NAME', $configs['app_name']);
