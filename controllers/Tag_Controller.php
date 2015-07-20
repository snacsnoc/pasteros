<?php

class Tag_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

    public function get_index($tag_id) {
        try {

            $get_tag = R::dispense('paste');
            $paste_tags = $get_tag->getTags($tag_id);

            //If no result is returned, return false 
            if (false === $paste_tags) {
                return false;
            }
            $this->title = $tag_id . " tag";

            //Pass the values to Twig and render the template
            return $this->twig->render('tag.twig', array('title' => $this->title,
                        'paste_tags' => $paste_tags,
                        'tag' => $tag_id,
                        'error' => $_SESSION['error']
                        ));

            //Once the error has been passed to Twig, change it to null so it only appears once
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

}