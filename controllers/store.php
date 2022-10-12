<?php

require_once 'models/ordermodel.php';

class Store extends SessionController{

    private $userStore = "";

    private $resultsPerPage = 24;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";

    function __construct(){
        parent::__construct();
        //error_log('Store::construct -> inicio de store');
    }

    function render(){
        //error_log('Store::render -> Carga el index de store');

        $this->getData();
        $this->page = $this->page.'/id'.'/'.$this->userStore;
        
        $this->view->render($this->lenguage, $this->lenguage.'/stores/store', 
        ["user" => $this->user, 
        "orders_list" => $this->orders_list, 
        "actualPage" => $this->actualPage, 
        "totalPages" => $this->totalPages, 
        "searchText" => $this->searchText, 
        "page" => $this->page,
        "lenguage" => $this->lenguage,
        "count" => $this->count]);
    }

    function setData($lenguage, $page){
        //error_log('Store::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function id($param = null){
        //error_log('Store::ID -> EJECUTO');

        if (!empty($param[0])) {
            $userStore = $param[0];

            if ($userStore != 0 && $userStore != null) {
                $this->userStore = $userStore;
            }
        }else{
            $this->redirect($this->lenguage.'/stores', []);
        }
        
        $this->render();
    }

    function getData(){
        //error_log('Store::getData -> EJECUTO');

        $order = new OrderModel();
        if($this->existGET(['wt', 'name', 'type', 'results', 'orderBy'])){
            $name = $this->getGet('name');
            $wt = $this->getGet('wt');
            $type = $this->getGet('type');
            $orderBy = $this->getGet('orderBy');

            $results = $this->getGet('results');
            if ($results != "" && $results > 0) {
                $this->resultsPerPage = $results;
            }

            $this->searchText = '&wt='.$wt.'&type='.$type.'&name='.$name.'&results='.$results.'&orderBy='.$orderBy;
            
            if ($orderBy == "") {
                $orderBy = "id_order";
            }
            
            $search = true;
            
        }else{
            $search = false;
        }
        
        if ($search) {
            $count =  $order->countSearch($this->userStore, $wt, $type, $name);
        }else{
            $count =  $order->countSearch($this->userStore, "", "", "");
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_STORE_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage); 
        }
        
        if ($search) {
            $result = $order->search($this->userStore, $wt, $type, $name, $orderBy, $this->actualPage, $this->resultsPerPage);
        }else{
            $result = $order->search($this->userStore, "", "", "", "id_order", $this->actualPage, $this->resultsPerPage);
        }

        if ($result == []) {
            $data = $order->search($this->userStore, "", "", "", "id_order", 1, 1);
            if ($data) {
                $result = $order->toUser($data);
            }else{
                $this->redirect($this->lenguage.'/stores', []);
            }
        }

        if ($result) {
            $this->orders_list = $result;
        }else{
            $this->redirect($this->lenguage.'/stores', ['error' => ErrorsMessages::ERROR_STORE_GETORDERS]);
        }
    }

    function page(){
        //error_log('Store::page -> EJECUTO');

        if ($this->existGET(['actualPage'])) {
            $actualPage = $this->getGet('actualPage');

            if ($actualPage != 0 && $actualPage != null) {
                $this->actualPage = $actualPage;
            }
        }
        
        $this->render();
    }
    
}
?>