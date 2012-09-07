<?php

class Add_Controller {

    public function post_index() {

        //If no content was sent, redirect back home
        if (!isset($_POST['content']) || empty($_POST['content'])) {
            $_SESSION['error'] = "content is empty!";
            return header('Location: /');
        }


        $content = $_POST['content'];


        //If the paste has no name, set a default name
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $name = 'pasteros paste';
        } else {
            $name = $_POST['name'];
        }

        //Syntax highlighting
        $language = $_POST['language'];

        //If the checkbox is checked, then the paste is not visible in the recent box
        if ($_POST['visible'] == true) {
            $visible = false;
        } else {
            $visible = true;
        }

        //If the post has no parent (not forked), assign the value null
        if ($_POST['parent_paste'] == null) {
            $parent_paste = null;
        } else {
            $parent_paste = intval($_POST['parent_paste']);
        }



        $paste_insert = R::dispense('content');
        
        $paste_insert->name = $name;
        $paste_insert->content = $content;
        $paste_insert->visible = $visible;
        $paste_insert->parent = $parent_paste;
        $paste_insert->language = $language;
        
        $insert_id = R::store($paste_insert);
        R::close();
        //If an ID is present, redirect to the paste's page
        if ($insert_id) {
            return header('Location: /' . $insert_id);
        } else {
            return false;
        }
    }

}