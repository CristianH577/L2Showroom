<?php
require_once 'models/itemsmodel.php';
require_once 'models/ordermodel.php';

class Admin extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Admin::construct -> inicio de admin');
    }

    function render(){
        //error_log('Admin::render -> Carga el index de admin');
        
        $this->view->render($this->lenguage, $this->lenguage.'/dashboard', 
        ["user" => $this->user]);
    }

    function setData($lenguage, $page){
        //error_log('Stores::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        //$this->route = $this->lenguage.'/'.$page;
        $this->route = $lenguage.'/dashboard';

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function deleteUser(){
        //error_log('Admin::deleteUser -> EJECUTO');

        if($this->existPOST(['id_user'])){
            $id = $this->getPost('id_user');

            $user = new UserModel();

            if (!$user->deleteOldImg($id)) {
                $this->redirect($this->lenguage."/users", ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_USER_IMG]);
            }

            if($user->delete($id)){
                $this->redirect($this->lenguage."/users", ['success' => SuccessMessages::SUCCESS_ADMIN_DELETE_USER]);
            }else{
                $this->redirect($this->lenguage."/users", ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_USER]);
            }
        }else{
            $this->redirect($this->lenguage."/users", ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_USER_FORM]);
        }
    }

    function deleteOrder(){
        //error_log('Admin::deleteOrder -> EJECUTO');

        if($this->existPOST(['id_order'])){
            $id_order = $this->getPost('id_order');

            $order = new OrderModel();

            if (!$order->getOrder($id_order)) {
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ORDER_DATA]);
            }

            if ($order->getCharImgs() != "") {
                if (!$order->deleteCharImgs($id_order)) {
                    //$this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_DELETE_ORDER_CHARIMGS]);/*AGREGAR*/
                    error_log('Admin::deleteOrder -> Error al eliminar char_imgs');
                }
            }

            if($order->delete()){
                $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_ADMIN_DELETE_ORDER]);
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ORDER]);
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ORDER_FORM]);
        }
    }

    function deleteItem(){
        //error_log('Admin::deleteItem -> EJECUTO');

        if($this->existPOST(['id_item'])){
            $id_item = $this->getPost('id_item');

            $item = new ItemsModel();

            if (!$item->deleteOldImg($id_item)) {
                $this->redirect($this->lenguage.'/items', ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ITEM_IMG]);
            }

            if($item->delete($id_item)){
                $this->redirect($this->lenguage.'/items', ['success' => SuccessMessages::SUCCESS_ADMIN_DELETE_ITEM]);
            }else{
                $this->redirect($this->lenguage.'/items', ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ITEM]);
            }
        }else{
            $this->redirect($this->lenguage.'/items', ['error' => ErrorsMessages::ERROR_ADMIN_DELETE_ITEM_FORM]);
        }
    }

}
?>