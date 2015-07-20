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

        //Set the paste tag to null if it is empty
        if (!isset($_POST['tag']) || empty($_POST['tag'])){
            $tag = null;
        }else{
            $tag = str_replace('/', '-', $_POST['tag']);
        }
        
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
            $parent_paste = $_POST['parent_paste'];
        }

        //Insert paste into the database and get the row ID
        $insert_id = Model_Paste::insertPaste(array('name' => $name,
                    'content' => $content,
                    'visible' => $visible,
                    'parent_paste' => $parent_paste,
                    'language' => $language,
                    'tag' => $tag), 'content');

        //If an ID is present, create a QR code redirect to the paste's page
        if ($insert_id) {
            \PHPQRCode\QRcode::png("https://pasteros.io/$insert_id", "/var/www/paste/public/images/qrcode/$insert_id.png", 'L', 4, 2);

            //Get that delete UUID we just made, and set a session variable to the unique ID
            $get_paste = R::dispense('paste');
            $paste_content = $get_paste->getPaste($insert_id);
            $_SESSION['delete_id'] = $paste_content['del_uuid'];

            return header('Location: /' . $insert_id);

        } else {
            return false;
        }
    }

}