<?php

require_once 'models/ordermodel.php';

class Market extends SessionController{

    private $resultsPerPage = 24;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";

    function __construct(){
        parent::__construct();
        //error_log('Market::construct -> inicio de market');
    }

    function render(){
        //error_log('Market::render -> Carga el index de market');

        //if (!$this->existGET(['error'])) $this->getData();
        $this->getData();

        $this->view->render($this->lenguage, $this->route.'/index', 
        ["user" => $this->user, 
        "orders_list" => $this->orders_list, 
        "actualPage" => $this->actualPage, 
        "totalPages" => $this->totalPages, 
        "searchText" => $this->searchText, 
        "lenguage" => $this->lenguage, 
        "count" => $this->count, 
        "page" => $this->page]);
    }

    function setData($lenguage, $page){
        //error_log('Stores::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function getData(){
        //error_log('Market::getData -> EJECUTO');

        $order = new OrderModel();
        if($this->existGET(['wt', 'type', 'name', 'results', 'orderBy'])){
            $wt = $this->getGet('wt');
            $type = $this->getGet('type');
            $name = $this->getGet('name');
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
            $count =  $order->countSearch('', $wt, $type, $name);
        }else{
            $count =  $order->count();
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MARKET_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage);
        }
        if ($this->actualPage > $this->totalPages) {
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MARKET_PAGE_NOEXIST]);
        }

        if ($search) {
            $result = $order->search('', $wt, $type, $name, $orderBy, $this->actualPage, $this->resultsPerPage);
        }
        else{
            $result = $order->getOrders($this->actualPage, $this->resultsPerPage);
        }

        if ($result || $result == []) {
            $this->orders_list = $result;
        }
        else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MARKET_GETORDERS]);
        }
    }

    function page(){
        //error_log('Stores::page -> EJECUTO');

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