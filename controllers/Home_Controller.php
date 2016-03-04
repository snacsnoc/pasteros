<?php

class Home_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }


    public function get_index() {
        try {
            $this->title = 'home';

            //Get the 15 most recent pasts
            $get_pastes = \RedBeanPHP\R::dispense('paste');
            $sidebar_result = $get_pastes->getRecentPastes(15);

            //We map it like so to correctly pass it to Twig
            $sidebar_array[] = $sidebar_result;

            return $this->twig->render('index.twig', array(
                'title' => $this->title, 'array' => $sidebar_array[0],
                'error' => $_SESSION['error']));
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
}