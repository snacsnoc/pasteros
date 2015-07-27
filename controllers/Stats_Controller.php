<?php

class Stats_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

    public function get_index() {
        try {

            $count_paste = R::dispense('paste');
            $paste_count = $count_paste->getCountByLanguage();
            $tag_count = $count_paste->getCountByTag();
            
            $this->title = "Stats";
           
            //Pass the values to Twig and render the template
            return $this->twig->render('stats.twig', array('title' => $this->title,
                        'paste' => $paste_count, 'tag_count' => $tag_count
                        ));

            //Once the error has been passed to Twig, change it to null so it only appears once
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

}