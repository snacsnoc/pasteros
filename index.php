<?php

//pasteros
//Easton E. 2012
//www.geekness.eu

session_start();

//Autoload models, controllers and libraries
require_once './autoloader.php';

R::setup('pgsql:host=localhost;dbname=paste', 'easto', 'eagle'); //postgres
//Uncomment to 'freeze' the database
//R::freeze(true);

Twig_Autoloader::register();

//Controller routes
require_once './routes.php';


dispatch();