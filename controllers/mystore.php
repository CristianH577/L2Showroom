<?php

require_once 'models/itemsmodel.php';
require_once 'models/ordermodel.php';

class Mystore extends SessionController{

    private $resultsPerPage = 20;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";

    function __construct(){
        parent::__construct();
        //error_log('Mystore::construct -> inicio de Mystore');
    }

    function render(){
        //error_log('Mystore::render -> Carga el index de Mystore');

        $this->getData();

        $this->view->render($this->lenguage, $this->lenguage.'/dashboard/mystore', 
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
        //error_log('Stores::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        $this->user = $this->getUserSessionData();
    }

    function getData(){
        //error_log('Mystore::getData -> EJECUTO');

        $order = new OrderModel();
        $id = $this->user->getID();
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
            $count =  $order->countSearch($id, $wt, $type, $name);
        }else{
            $count =  $order->countSearch($id, "", "", "");
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage); 
        }
        if ($this->actualPage > $this->totalPages) {
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_PAGE_NOEXIST]);
        }

        if ($search) {
            $result = $order->search($id, $wt, $type, $name, $orderBy, $this->actualPage, $this->resultsPerPage);
        }else{
            $result = $order->search($id, "", "", "", "id_order", $this->actualPage, $this->resultsPerPage);
        }

        if ($result || $result == []) {
            $this->orders_list = $result;
        }
        else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_GETORDERDS]);
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

    function validateNewOrderItem(){
        //error_log('Mystore::validateNewOrderItem -> EJECUTA');
        
        if ($this->existGET(['user', 'item'])) {
            $user = $this->getGet('user');
            $item = $this->getGet('item');

            $order = new OrderModel();

            if ($order->existOrder($user, $item)) {
                $answer = "true";
            }else{
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function validateNewOrderChar(){
        //error_log('Mystore::validateNewOrderChar -> EJECUTA');
        
        if ($this->existGET(['user', 'data'])) {
            $user = $this->getGet('user');
            $data = $this->getGet('data');

            $order = new OrderModel();

            if ($order->existOrderChar($user, $data)) {
                $answer = "true";
            }else{
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function newOrder(){
        //error_log('Mystore::newOrder -> EJECUTA');

        if($this->existPOST(['type', 'wt', 'price'])){
            $id_user = $this->user->getID();
            $type = $this->getPost('type');
            $wt = $this->getPost('wt');
            
            $price = $this->getPost('price');
            $price = str_replace(",","",$price);
        
            $date = new DateTime();  
            $date_register = $date->format("Y-m-d h:i:s a");

            $order = new OrderModel();
            $order->setIDUser($id_user);
            $order->setWt($wt);
            $order->setPrice($price);
            $order->setRegister($date_register);

            switch ($type) {
                case 'item':
                    if($this->existPOST(['id_item', 'quantity'])){
                        $id_item = $this->getPost('id_item');
                        
                        $quantity = $this->getPost('quantity');
                        $quantity = str_replace(",","",$quantity);

                        $order->setIDItem($id_item);
                        $order->setQuantity($quantity);
            
                        if($order->save()){
                            $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_MYSTORE_NEWORDER]);
                        }else{
                            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_ITEM]);
                        }
        
                    }else{
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_FORM_ITEM]);
                    }
                    break;
                
                case 'char':
                    if($this->existPOST(['race', 'occupation', 'class', 'level'])){
                        $race = $this->getPost('race');
                        $occupation = $this->getPost('occupation');
                        $class = $this->getPost('class');
                        $level = $this->getPost('level');

                        $char_data = $race."_".$occupation."_".$class;
                        $char_data_level = $char_data."_".$level;
                        
                        $order->setCharData($char_data_level);
                        $order->setQuantity("1");
    
                        if (isset($_FILES['img1']) 
                        && isset($_FILES['img2']) 
                        && isset($_FILES['img3']) 
                        && isset($_FILES['img4'])) {
                            $e = 0;
                            $directorio = "assets/chars/";
                            $char_imgs = "";

                            for ($i=1; $i < 5; $i++) {
                                $file = "img".$i;
                                if ($_FILES[$file]['name'] != "") {
                                    $img_name[$i] = $_FILES[$file]['name'];
                                    $img_temp[$i] = $_FILES[$file]['tmp_name'];

                                    $extension_img[$i] = pathinfo($img_name[$i], PATHINFO_EXTENSION);
                                    $img_img[$i] = $id_user."_".$char_data."_img".$i.".".$extension_img[$i];
                                    $img_img_path[$i] = $directorio.$img_img[$i];
                    
                                    if(!move_uploaded_file($img_temp[$i], $img_img_path[$i])){
                                        $e++;
                                    }

                                    $char_imgs = $char_imgs.$img_img[$i].",";
                                }
                                
                            }

                            if ($e > 1) {
                                $h = 0;
                                $char_imgs = "";
                                
                                for ($i=1; $i < 5; $i++) { 
                                    $delete_img[$i] = $directorio.$img_img[$i];
                                    if (file_exists($delete_img[$i])) {
                                        if (!unlink($delete_img[$i])) {
                                            $h++;
                                        }
                                    }
                                }

                                if ($h != 0) {
                                    error_log('Mystore::newOrder -> Hubo un error al eliminar los archivos');
                                }

                                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_FORM_IMGS_MOVE]);
                            }else{
                                $char_imgs = rtrim($char_imgs, ",");
                                $order->setCharImgs($char_imgs);
                    
                                if($order->save()){
                                    $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_MYSTORE_NEWORDER]);
                                }else{
                                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_CHAR]);
                                }
                            }

                        }else{
                            //error_log('Mystore::newOrder -> Hubo un error al tomar los archivos');
                            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_FORM_IMGS]);
                        }
        
                    }else{
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_FORM_CHAR]);
                    }
                    break;
                
                default:
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_TYPE]);
                    break;
            }
            
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_NEWORDER_FORM]);
        }
    }

    function deleteOrder(){
        //error_log('Mystore::deleteOrder -> EJECUTO');

        if($this->existPOST(['id_order'])){
            $id_order = $this->getPost('id_order');

            $order = new OrderModel();

            if (!$order->getOrder($id_order)) {
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_DELETE_ORDER_DATA]);
            }

            if ($order->getCharImgs() != "") {
                if (!$order->deleteCharImgs($id_order)) {
                    //$this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_DELETE_ORDER_CHARIMGS]);/*AGREGAR*/
                    error_log('Mystore::deleteOrder -> Error al eliminar char_imgs');
                }
            }

            if($order->delete()){
                $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_MYSTORE_DELETE]);
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_DELETE_ORDER]);
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_MYSTORE_DELETE_ORDER_FORM]);
        }
    }

    function searchItemName(){
        //error_log('Mystore::searchItemName -> EJECUTO');

        if ($this->existGET(['name'])) {
            $name = $this->getGet('name');

            $item = new ItemsModel();
            $result = $item->searchNames($name);

            if ($result) {
                $answer = $result;
            }else{
                $answer = "false";
            }

        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function searchItemImg(){
        //error_log('Mystore::searchItemImg -> EJECUTO');

        if ($this->existGET(['name'])) {
            $name = $this->getGet('name');

            $item = new ItemsModel();
            $result = $item->searchIMG($name);
    
            if ($result) {
                $answer = $result;
            }else{
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function searchID(){
        //error_log('Mystore::searchID -> EJECUTO');

        if ($this->existGET(['name'])) {
            $name = $this->getGet('name');

            $item = new ItemsModel();
            $result = $item->searchID($name);
    
            if ($result) {
                $answer = $result;
            }else{
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }
    
}
?>