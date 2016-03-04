<?php

class Delete_Controller extends Base_Controller {

    function __construct() {
        //Include Twig
        parent::getTwig();
    }

public function get_index($paste_id, $delete_id) {


            $get_paste = \RedBeanPHP\R::dispense('paste');
            $paste_content = $get_paste->getPaste($paste_id);

            //If no result is returned, return false 
            if (false === $paste_content) {
                return false;
            }

            $uuid = $paste_content['uuid'];
            $delete_uuid = $paste_content['del_uuid'];

            if($delete_uuid === $delete_id){


            	$get_paste = \RedBeanPHP\R::dispense('paste');
        		$paste_content = $get_paste->deletePaste($paste_id, $delete_id);
        		if(true == $paste_content){
        			return true;
        		}else{
        			return false;
        		}	
            }else{
            	return false;
            }



}


}