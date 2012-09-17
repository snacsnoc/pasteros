<?php

class View_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

    public function get_index($paste_id) {
        try {

            $get_paste = R::dispense('paste');
            $paste_content = $get_paste->getPaste($paste_id);

            //If no result is returned, return false 
            if (false === $paste_content) {
                return false;
            }

            $name = $paste_content['name'];
            $content = $paste_content['content'];

            //Assign the page title
            $this->title = $name;

            $paste_time = $paste_content['time'];
            $id = $paste_content['id'];
            $language = $paste_content['language'];
            
            //If forking a post
            if (isset($paste_content['parent'])) {
                $parent_paste = $paste_content['parent'];
            } else {
                $parent_paste = null;
            }

            //Send this to Twig to allow forked posts the same visibility
            if (isset($paste_content['visible'])) {
                $is_visible = false;
            }
            //Set the default text theme
            if (empty($_COOKIE['csstheme'])) {
                setcookie('csstheme', 'Default',  time()+60*60*24*30);
            }

            //Calculate the difference from the current time to the time the paste was uploaded
            $time_difference = time() - strtotime($paste_time);


            $diff = array('time' => $time_difference,
                'unit' => 'seconds');

            //If diff['time'] is over 60, go to hours, then days etc
            if ($diff['time'] > 60) {
                $diff = array('time' => round($diff['time'] / 60, 1), 'unit' => 'minutes');

                if ($diff['time'] > 60) {
                    $diff = array('time' => round($diff['time'] / 60, 1), 'unit' => 'hours');
                }
                if ($diff['time'] > 24) {
                    $diff = array('time' => round($diff['time'] / 24, 2), 'unit' => 'days');
                }
            }


            //Pass the values to Twig and render the template
            return $this->twig->render('view.twig', array('title' => $this->title,
                        'name' => $name,
                        'content' => $content,
                        'id' => $id,
                        'time' => $paste_time,
                        'is_visible' => $is_visible,
                        'parent_paste' => $parent_paste,
                        'diff' => $diff,
                        'language' => $language,
                        'error' => $_SESSION['error'],
                        'csstheme' => $_COOKIE['csstheme']));

            //Once the error has been passed to Twig, change it to null so it only appears once
            $_SESSION['error'] = null;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }

    public function get_raw($paste_id) {

        //Select the paste based on the ID given
        $get_paste = R::dispense('paste');
        $paste_content = $get_paste->getPaste($paste_id);

        $content = $paste_content['content'];

        //Allow the user to view the raw content
        header('Content-type: text/plain');
        header("Content-Transfer-Encoding: binary");
        header("Content-Description: File Transfer");
        return $content;
    }

    public function get_download($paste_id) {

        //Select the paste based on the ID given
        $get_paste = R::dispense('paste');
        $paste_content = $get_paste->getPaste($paste_id);


        $name = tempnam('temp/', $paste_content['name']);
        $content = $paste_content['content'];
        
        //Create a 'temporary' file and force the user to download
        file_put_contents("$name.txt", $content);
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$name.txt");
        header("Content-Type: text/plain");
        header("Content-Transfer-Encoding: binary");
        readfile("$name.txt");
    }

    public function get_diff($paste_id, $parent_id) {

        //Get the two pastes
        $get_paste = R::dispense('paste');
        $diff_content = $get_paste->getDiffPaste($paste_id, $parent_id);

        $fork_paste = $diff_content[0];
        $parent_paste = $diff_content[1];


        //Set page title
        $this->title = $fork_paste['name'] . ' [diff]';


        //Get opcode(?) for diff
        $opcodes = FineDiff::getDiffOpcodes($parent_paste['content'], $fork_paste['content'] /* , default granularity is set to character */);
        //Render the opcode to an HTML diff
        $textdiff = FineDiff::renderDiffToHTMLFromOpcodes($parent_paste['content'], $opcodes);

        //Pass the values to Twig and render the template
        return $this->twig->render('diff.twig', array('title' => $this->title,
                    'fork_paste' => $fork_paste, 'parent_paste' => $parent_paste,
                    'textdiff' => $textdiff, 'error' => $_SESSION['error']));
        $_SESSION['error'] = null;
    }

}