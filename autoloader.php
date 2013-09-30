<?php

//Autoload classes from the models and controllers directories
function classLoader($class_name) {
    $class_directories = array("models", "controllers");
    $classString = '';
    foreach ($class_directories as $value) {
        $classString = APP_PATH. '/' . $value . '/' . $class_name . '.php';
        if (file_exists($classString)) {
            require_once $classString;
        }
    }
}

//Autoload the required libraries
function libraryLoader() {
    $libraries = array(
        'libraries/rb.php',
        'libraries/finediff.php');

    $library_path = '';
    foreach ($libraries as $value) {
        $library_path = APP_PATH . '/' . $value;
        if (file_exists($library_path)) {
            require_once $library_path;
        }
    }
}

//Register it
spl_autoload_register('classLoader');
spl_autoload_register('libraryLoader');
