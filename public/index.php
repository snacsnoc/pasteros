<?php

//pasteros
//Easton E. 2012
//www.geekness.eu

error_reporting(-1);


ini_set('display_errors', 1);

define('APP_PATH', realpath('../'));

session_start();

//Autoload models, controllers and libraries
require_once APP_PATH.'/autoloader.php';

R::setup('pgsql:host=localhost;dbname=paste', 'test', 'test'); //postgres
//Uncomment to 'freeze' the database
//R::freeze(true);

Twig_Autoloader::register();

//Controller routes
require_once APP_PATH.'/routes.php';


dispatch();