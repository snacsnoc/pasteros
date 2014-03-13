<?php

/**
 * Controller to handle diffs
 *
 * @author Easton Elliott <easton@geekness.eu>
 */
class Diff_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

    public function get_index() {
        $this->title = 'online diff';

        return $this->twig->render('creatediff.twig', array(
                    'title' => $this->title,
                    'error' => unserialize($_SESSION['error'])));
        $_SESSION['error'] = null;
    }

}

?>
