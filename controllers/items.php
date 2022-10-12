<?php

class Items extends SessionController{

    private $resultsPerPage = 24;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";

    function __construct(){
        parent::__construct();
        //error_log('Items::construct -> inicio de Items');
    }

    function render(){
        //error_log('Items::render -> Carga el index de Items');

        $this->getData();
        
        $this->view->render($this->lenguage, $this->lenguage.'/market/items', 
        ["user" => $this->user, 
        "items_list" => $this->items_list, 
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
        $this->route = $lenguage."/".$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }
    
    function getData(){
        //error_log('Items::getData -> EJECUTO');

        $item = new ItemsModel();
        if($this->existGET(['type', 'name', 'description', 'results', 'orderBy'])){
            $name = $this->getGet('name');
            $type = $this->getGet('type');
            $description = $this->getGet('description');
            $orderBy = $this->getGet('orderBy');

            $results = $this->getGet('results');
            if ($results != "" && $results > 0) {
                $this->resultsPerPage = $results;
            }

            $this->searchText = '&name='.$name.'&type='.$type.'&description='.$description.'&results='.$results.'&orderBy='.$orderBy;

            if ($orderBy == "") {
                $orderBy = "id_item";
            }
            
            $search = true;
            
        }else{
            $search = false;
        }

        if ($search) {
            $count =  $item->countSearch($name, $type, $description);
        }else{
            $count =  $item->count();
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage);
        }
        if ($this->actualPage > $this->totalPages) {
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_PAGE_NOEXIST]);
        }

        if ($search) {
            $result = $item->search($type, $name, $description, $orderBy, $this->actualPage, $this->resultsPerPage);
        }else{
            $result = $item->getItems($this->actualPage, $this->resultsPerPage);
        }

        if ($result || $result == []) {
            $this->items_list = $result;
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_GETITEMS]);
        }
    }

    function page(){
        //error_log('Items::page -> EJECUTO');

        if ($this->existGET(['actualPage'])) {
            $actualPage = $this->getGet('actualPage');

            if ($actualPage != 0 && $actualPage != null) {
                $this->actualPage = $actualPage;
            }
        }
        
        $this->render();
    }

    function validateNewItem(){
        //error_log('Items::validateNewItem -> EJECUTO');

        if ($this->existGET(['name'])) {
            $name = $this->getGet('name');

            $item = new ItemsModel();
            $result = $item->searchID($name);
        
            if($result){
                $answer = "true";
            }else{
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function newItem(){
        //error_log('Items::newItem -> EJECUTO');

        if($this->existPOST(['add_name', 'add_type', 'add_description'])){
            $name = $this->getPost('add_name');
            $type = $this->getPost('add_type');
            $description = $this->getPost('add_description');
            if ($description == "") {
                $description = "-";
            }
            
            $item = new ItemsModel();
            $item->setName($name);
            $item->setType($type);
            $item->setDescription($description);

            if($item->save()){
                $result = $item->searchID($name);

                if ($result) {
                    $id = $result;
                    $item->setId($id);

                    if (isset($_FILES['new_icon']) && $_FILES['new_icon']['tmp_name'] != "") {
                        $new_icon = $_FILES['new_icon']['name'];
        
                        $new_icon_temp = $_FILES['new_icon']['tmp_name'];
                        $directorio = "assets/items/" ;
                        $extension = pathinfo($new_icon, PATHINFO_EXTENSION);
                        $icon = $id.".".$extension;
                        $icon_path = $directorio.$icon;
        
                        if(!move_uploaded_file($new_icon_temp, $icon_path)){
                            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_NEWITEM_SAVE_IMG]);
                        }
                    }else{
                        $icon = "default.svg";
                    }
        
                    $item->setImg($icon);
    
                    if(!$item->updateImg()){
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_NEWITEM_UPDATE_IMG]);
                    }

                }else{
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_NEWITEM_IMG_ID]);
                }

                $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_ITEMS_NEWITEM]);
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_NEWITEM]);
            }

        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_ITEMS_NEWITEM_FORM]);
        }
    }

}
?>