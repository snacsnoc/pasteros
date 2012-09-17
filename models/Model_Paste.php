<?php

class Model_Paste extends RedBean_SimpleModel {

    /**
     * @return awesome Awesome output 
     */
    public function octodad() {
        return 'meow';
    }

    /**
     * Retrieve the most recent pastes, for display on the homepage
     * @param int $recent_limit Set the limit to the amount of pastes retrieved
     * @return array Most recent pastes
     */
    public static function getRecentPastes($paste_limit) {

        $sidebar_result = R::getAll("SELECT * FROM content WHERE visible = TRUE ORDER BY id DESC LIMIT $paste_limit OFFSET 0");
        return $sidebar_result;
    }

    /**
     * Retrieve an individual paste given the ID
     * @param int $paste_id Individual paste ID
     * @return array Paste's contents
     */
    public static function getPaste($paste_id) {

        //Select the paste based on the ID given
        $paste_content = R::getAll("SELECT * 
        FROM content 
        WHERE content.id = '$paste_id' LIMIT 1");

        //If the lookup failed, return false
        if (null == $paste_content) {
            return false;
        } else {
            return $paste_content[0];
        }
    }

    /**
     * Select two pastes which one has been forked and the other is the parent
     * @param int $paste_id Forked paste ID
     * @param int $parent_id Parent paste ID
     * @return array Array of both paste's contents
     */
    public static function getDiffPaste($paste_id, $parent_id) {

        //Get the forked paste
        $fork_paste = R::getAll("SELECT content.content, content.name, content.id
        FROM content 
        WHERE content.id = '$paste_id' AND  content.parent = '$parent_id'");

        //Get the parent paste 
        $parent_paste = R::getAll("SELECT content.content, content.id
        FROM content 
        WHERE content.id = '$parent_id'");

        //If there are no results in either query, return false
        if (null == $fork_paste || null == $parent_paste) {
            return false;
        } else {
            return array($fork_paste[0], $parent_paste[0]);
        }
    }

    /**
     * Insert paste into database
     * @param array $content Input
     * @param string $database_name Database name
     * @return mixed Returns the insert ID or false if an error occured
     */
    public static function insertPaste($content = array(), $database_name) {

        $paste_insert = R::dispense($database_name);
        $paste_insert->name = $content['name'];
        $paste_insert->content = $content['content'];
        $paste_insert->visible = $content['visible'];
        $paste_insert->parent = $content['parent_paste'];
        $paste_insert->language = $content['language'];

        $insert_id = R::store($paste_insert);
        R::close();

        if (true == $insert_id) {
            return $insert_id;
        } else {
            return false;
        }
    }

}