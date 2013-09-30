<?php

//pasteros
//Easton E. 2013
//www.geekness.eu

error_reporting(E_ALL);
ini_set('display_errors',0);

define('APP_PATH', realpath('../'));

session_start();

//Autoload models, controllers and libraries
require_once APP_PATH.'/autoloader.php';
require '../vendor/autoload.php';

R::setup('pgsql:host=localhost;dbname=DATABASENAME', 'USERNAME', 'PASSWORD'); //postgres
//Uncomment to 'freeze' the database
#R::freeze(true);

Twig_Autoloader::register();

//Controller routes
require_once APP_PATH.'/routes.php';

date_default_timezone_set('GMT');

$klein->dispatch();