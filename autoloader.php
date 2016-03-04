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

//Register it
spl_autoload_register('classLoader');