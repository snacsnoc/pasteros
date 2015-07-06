<?php

class Api_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

    public function get_index() {
        try {
            $this->title = 'API';

            return $this->twig->render('api.twig', array(
                        'title' => $this->title,
                        'error' => unserialize($_SESSION['error'])));
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    public function post_create() {
        try {

            $data = json_decode(file_get_contents("php://input"), true);
            
            //Set default values
            switch (false) {
                case $data['name']:
                    $data['name'] = 'pasteros paste';
                    continue;

                case $data['content']:
                    $response = array(
                        'error' => 'No content sent'
                    );
                    break;
            }

            if (!isset($data['visible'])) {
                $data['visible'] = false;
            }

            if (!isset($data['language'])) {
                $data['language'] = 'plain';
            }



            //Check if there's content
            if (false !== $data['content']) {

                //Insert paste into the database and get the paste UUID
                $insert_id = Model_Paste::insertPaste(array('name' => $data['name'],
                            'content' => $data['content'],
                            'visible' => $data['visible'],
                            'parent_paste' => null,
                            'language' => $data['language']), 'content');


                //Create a response
                if (true == $insert_id) {

                    //Get the unique delete ID
                    $get_paste = R::dispense('paste');
                    $paste_content = $get_paste->getPaste($insert_id);
                    $delete_id = $paste_content['del_uuid'];


                    $response = array('id' => $insert_id, 'delete_id' => $delete_id);
                } else {
                    $response = array(
                        'error' => 'No ID returned, something went wrong'
                    );
                }
            }

            

            return json_encode($response);
            header('Content-type: application/json');
        } catch (Exception $e) {
            

            echo json_encode($response);
            //Code via http://docs.php.net/manual/en/function.json-last-error.php
            // ;)
            switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return 'No errors, possibly missing content';
            break;

            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded';
            break;

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch';
            break;

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found';
            break;

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON';
            break;

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;

            default:
                return 'Unknown error';
            break;
    }
        }
    }

    public function post_simplecreate() {
        try {

            $data['content'] = file_get_contents('php://input');


            //Set default values
            $data['name'] = 'pasteros paste';
            $data['language'] = 'plain';
            $data['visible'] = false;


            //Check if there's content
            if (false !== $data['content']) {

                //Insert paste into the database and get the paste UUID
                $insert_id = Model_Paste::insertPaste(array('name' => $data['name'],
                            'content' => $data['content'],
                            'visible' => $data['visible'],
                            'parent_paste' => null,
                            'language' => $data['language']), 'content');


                //Create a response
                if (true == $insert_id) {
                    $response = $insert_id;
                } else {
                    $response = 'No ID returned, something went wrong';
                }

            }


            return $response;

        } catch (Exception $e) {
            die('Something went horribly wrong!');
        }
    }    

}

