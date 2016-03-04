<?php

class Base_Controller {
    
    /**
     * Load Twig 
     */
    public function getTwig() {
        //I have no idea what I'm doing
        $this->twig_loader = new Twig_Loader_Filesystem(APP_PATH.'/views');
        $this->twig = new Twig_Environment($this->twig_loader, array(
    				'cache' => APP_PATH.'/cache'
));

}


}