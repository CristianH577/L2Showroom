<?php

class Maintenance extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Errors::construct -> inicio de errores');
    }

    function render(){
        //error_log('Errors::render -> Carga el index de Errores');

        $this->view->render($this->lenguage, $this->lenguage.'/errors/maintenance', 
        ["user" => "", 
        "lenguage" => $this->lenguage]);
    }

    function setData($lenguage, $page){
        //error_log('Stores::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;
    }
}

?>
