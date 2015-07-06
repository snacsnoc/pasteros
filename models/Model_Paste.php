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
    public static function getPasteID($paste_id) {

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
     * Retrieve an individual paste given the UUID
     * @param string $paste_id Individual paste UUID
     * @return array Paste's contents
     */
    public static function getPaste($paste_uuid) {

        //Select the paste based on the ID given
        $paste_content = R::getAll("SELECT * 
        FROM content 
        WHERE content.uuid = '$paste_uuid' LIMIT 1");

        //If the lookup failed, return false
        if (null == $paste_content) {
            return false;
        } else {
            return $paste_content[0];
        }
    }

    /**
     * Select two pastes which one has been forked and the other is the parent
     * @param string $paste_id Forked paste UUID
     * @param string $parent_id Parent paste UUID
     * @return array Array of both paste's contents
     */
    public static function getDiffPaste($paste_id, $parent_id) {

        //Get the forked paste
        $fork_paste = R::getAll("SELECT content.content, content.name, content.uuid
        FROM content 
        WHERE content.uuid = '$paste_id' AND  content.parent = '$parent_id'");

        //Get the parent paste 
        $parent_paste = R::getAll("SELECT content.content, content.uuid
        FROM content 
        WHERE content.uuid = '$parent_id'");

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
     * @return mixed Returns the paste UUID or false if an error occured
     */
    public static function insertPaste($content = array(), $database_name) {
        //Generate 13 character unique ID for the paste
        $unique_id = uniqid();
        //Generate unique ID for paste deletion 
        $delete_unique_id = bin2hex(openssl_random_pseudo_bytes(10));

        $paste_insert = R::dispense($database_name);
        $paste_insert->name = $content['name'];
        $paste_insert->content = $content['content'];
        $paste_insert->visible = $content['visible'];
        $paste_insert->parent = $content['parent_paste'];
        $paste_insert->language = $content['language'];
        $paste_insert->uuid = $unique_id;
        $paste_insert->tag = $content['tag'];
        $paste_insert->del_uuid = $delete_unique_id;
        $insert_id = R::store($paste_insert);
        R::close();

        if (true == $insert_id) {
            return $unique_id;
        } else {
            return false;
        }
    }

    /**
     * Retrieve pastes with a given tag
     * @param string $tag_id Tag
     * @return array All pastes with given tag
     */
    public static function getTags($tag_id) {

        //Select the paste based on the ID given
        $paste_tags = R::getAll("SELECT * 
        FROM content 
        WHERE content.tag = '$tag_id'");

        //If the lookup failed, return false
        if (null == $paste_tags) {
            return false;
        } else {
            return $paste_tags;
        }
    }

    /**
     * Delete an individual paste given the UUID and delete UUID
     * @param string $paste_uuid Individual paste UUID
     * @param string $delete_uuid Individual paste UUID     
     * @return boolean True or false depending on result
     */
    public static function deletePaste($paste_uuid, $delete_uuid) {

        //Select the paste based on the ID given
        $paste_delete = R::getAll("DELETE 
        FROM content 
        WHERE content.uuid = '$paste_uuid' AND content.del_uuid = '$delete_uuid'");

        if (true === $paste_delete) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Retrieve the amount (count) of pastes by language
     * @return array Language and count of pastes with that language
     */
    public static function getCountByLanguage() {

        return R::getAll('SELECT content.language, COUNT(content.language) FROM content GROUP BY content.language ORDER BY count DESC');
        
    }

}