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
        if ("false" == $_POST['visible']) {
            $visible = false;
        }else{
            $visible = true;
        }

        //If the post has no parent (not forked), assign the value null
        if ($_POST['parent_paste'] == null) {
            $parent_paste = null;
        } else {
            $parent_paste = intval($_POST['parent_paste']);
        }

        //Insert paste into the database and get the row ID
        $insert_id = Model_Paste::insertPaste(array('name' => $name,
                    'content' => $content,
                    'visible' => $visible,
                    'parent_paste' => $parent_paste,
                    'language' => $language), 'content');

        //If an ID is present, create a QR code redirect to the paste's page
        if ($insert_id) {
            \PHPQRCode\QRcode::png("http://paste.gelat.in/$insert_id", "/var/www/paste/public/images/qrcode/$insert_id.png", 'L', 4, 2);
            return header('Location: /' . $insert_id);

        } else {
            return false;
        }
    }

}