<?php

require_once 'models/ordermodel.php';

class Main extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Main::construct -> inicio de main');
    }

    function render(){
        //error_log('Main::render -> Carga el index de main');

        if (!$this->existGET(['error'])) {
            $this->getData();
        }

        $this->view->render($this->lenguage, $this->route.'/index', 
        ["user" => $this->user, 
        "new_orders_list" => $this->new_orders_list, 
        "new_users_list" => $this->new_users_list, 
        "new_users_orders_list" => $this->new_users_orders_list, 
        "page" => $this->page,
        "lenguage" => $this->lenguage]);
    }

    function setData($lenguage, $page){
        //error_log('MAIN::setData -> EJECUTO');
        
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
        //error_log('MAIN::getData -> EJECUTO');
        $order = new OrderModel();

        //new orders
        $search_new_orders = $order->search("", "", "", "", "id_order DESC", 1, 5);
        
        if ($search_new_orders || $search_new_orders == []) {
            $this->new_orders_list = $search_new_orders;
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MAIN_NEWORDERS]);
        }

        //new users
        $search_new_users = $order->getUsers("id_user DESC",1,6);

        if ($search_new_users || $search_new_users == []) {
            $this->new_users_list = $search_new_users;
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MAIN_NEWUSERS]);
        }

        $new_users_orders_list = [];
        for ($i=0; $i < sizeof($this->new_users_list); $i++) {
            $id = $this->new_users_list[$i];
            $addOrders = $order->search($id, "", "", "", "id_order DESC", 1, 3);
            
            if ($addOrders || $addOrders == []) {
                $new_users_orders_list[$id] = $addOrders;
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MAIN_NEWUSERS_ORDERS]);
            }
        }
        $this->new_users_orders_list = $new_users_orders_list;
    }
    
}
?>