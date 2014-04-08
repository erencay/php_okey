<?
ini_set('error_reporting', E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
set_time_limit(0);

define('SERVER_HOST', '127.0.0.1');
define('SERVER_PORT', 843);

define('DATABASE_DSN', 'sqlite:database.sqlite3');
define('DATABASE_USERNAME', NULL);
define('DATABASE_PASSWORD', NULL);

define('SALT', '1e688815578616e5c9e4f0da92fe150e7352f6b5');