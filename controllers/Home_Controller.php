<?php

class Home_Controller {

    function __construct() {

        $this->twig_loader = new Twig_Loader_Filesystem('views');
        $this->twig = new Twig_Environment($this->twig_loader);
    }

    public function get_index() {
        try {
            $this->title = 'home';

            //Get the 15 most recent pasts
            $get_pastes = R::dispense('paste');
            $sidebar_result = $get_pastes->getRecentPastes(15);

            //We map it like so to correctly pass it to Twig
            $sidebar_array[] = $sidebar_result;

            echo $this->twig->render('index.twig', array(
                'title' => $this->title, 'array' => $sidebar_array[0],
                'error' => $_SESSION['error']));
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
}