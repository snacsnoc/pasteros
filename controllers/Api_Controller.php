<?php

class Api_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }


    public function get_index() {
        $this->title = 'API';

        echo $this->twig->render('api.twig', array(
            'title' => $this->title, 'array' => $sidebar_array[0],
            'error' => $_SESSION['error']));
        $_SESSION['error'] = null;
    }

}

?>
