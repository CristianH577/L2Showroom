<?php
require_once 'models/ordermodel.php';
class Stores extends SessionController{

    private $resultsPerPage = 12;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";
    private $page;
    private $lenguage;
    private $route;

    function __construct(){
        parent::__construct();
        //error_log('Stores::construct -> inicio de Stores');
    }

    function render(){
        //error_log('Stores::render -> Carga el index de Stores');
        
        $this->getData();

        $this->view->render($this->lenguage, $this->route.'/index', 
        ["user" => $this->user, 
        "orders_list" => $this->orders_list, 
        "users_list" => $this->users_list, 
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
        //error_log('Stores::getData -> EJECUTO');

        $order = new OrderModel();

        if($this->existGET(['nick', 'discord', 'results', 'orderBy'])){
            $nick = $this->getGet('nick');
            $discord = $this->getGet('discord');
            $orderBy = $this->getGet('orderBy');

            $results = $this->getGet('results');
            if ($results != "" && $results > 0) {
                $this->resultsPerPage = $results;
            }

            $this->searchText = '&nick='.$nick.'&discord='.$discord.'&results='.$results.'&orderBy='.$orderBy;
            
            if ($orderBy == "") {
                $orderBy = "id_user";
            }

            $search = true;
        }else{
            $search = false;
            $orderBy = "id_user";
        }

        if ($search) {
            $count =  $order->countUsersSearch($nick, $discord);
        }else{
            $count =  $order->countUsers();
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_STORES_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage);  
        }
        if ($this->actualPage > $this->totalPages) {
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_STORES_PAGE_NOEXIST]);
        }

        if ($search) {
            $resultUsers = $order->getUsersSearch($nick, $discord, $orderBy, $this->actualPage, $this->resultsPerPage);
        }else{
            $resultUsers = $order->getUsers($orderBy, $this->actualPage, $this->resultsPerPage);
        }

        if ($resultUsers || $resultUsers == []) {
            $this->users_list = $resultUsers;
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_STORES_GETUSERS]);
        }

        if (sizeof($this->users_list) < $this->resultsPerPage) {
            $to = sizeof($this->users_list);
        }else{
            $to = $this->resultsPerPage;
        }

        $this->orders_list = [];
        for ($i=0; $i < $to; $i++) {
            $id = $this->users_list[$i];
            $user_orders = $order->search($id, "", "", "", "id_order", 1, 3);
            if ($user_orders || $user_orders == []) {
                $this->orders_list[$id] = $user_orders;
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_STORES_GETUSERS_ORDERS]);
            }
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