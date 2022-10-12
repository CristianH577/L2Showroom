<?php
require_once 'models/ordermodel.php';
require_once 'models/usermodel.php';
require_once 'models/itemsmodel.php';

class Users extends SessionController{

    private $resultsPerPage = 20;
    private $actualPage = 1;
    private $totalPages = 1;
    private $searchText = "";

    function __construct(){
        parent::__construct();
        //error_log('Users::construct -> inicio de users');
    }

    function render(){
        //error_log('Users::render -> Carga el index de users');

        $this->getData();

        $this->view->render($this->lenguage, $this->lenguage.'/admin/users', 
        ["user" => $this->user, 
        "users_list" => $this->users_list, 
        "actualPage" => $this->actualPage, 
        "totalPages" => $this->totalPages, 
        "searchText" => $this->searchText,  
        "page" => $this->page,
        "lenguage" => $this->lenguage,
        "count" => $this->count]);
    }

    function setData($lenguage, $page){
        //error_log('Users::setData -> EJECUTO');
        
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
        //error_log('Users::getData -> EJECUTO');

        $user = new UserModel();
        if($this->existGET(['id', 'email', 'nick', 'results', 'orderBy'])){
            $nick = $this->getGet('nick');
            $id = $this->getGet('id');
            $email = $this->getGet('email');
            $orderBy = $this->getGet('orderBy');

            $resultsPerPage = $this->getGet('results');
            if ($resultsPerPage != "" && $resultsPerPage > 0) {
                $this->resultsPerPage = $resultsPerPage;
            }

            $this->searchText = '?id='.$id.'&email='.$email.'&nick='.$nick.'&results='.$resultsPerPage.'&orderBy='.$orderBy;

            if ($orderBy == "") {
                $orderBy = "id_user";
            }
            
            $search = true;
        }else{
            $search = false;
        }

        if ($search) {
        $count =  $user->countSearch($id, $email, $nick);
        }else{
            $count =  $user->count();
        }

        if ($count || $count == 0) {
            $this->count = $count;
            if ($count <= $this->resultsPerPage) {
                $pagination = false;
            }else{
                $pagination = true;
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_USERS_COUNT]);
        }

        if ($pagination) {
            $this->totalPages = ceil($count/$this->resultsPerPage);   
        }
        if ($this->actualPage > $this->totalPages) {
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_USERS_PAGE_NOEXIST]);
        }

        $role = $this->user->getRole();
        if ($search) {
            $result = $user->search($id, $email, $nick, $orderBy, $this->actualPage, $this->resultsPerPage, $role);
        }else{
            $result = $user->getUsers($this->actualPage, $this->resultsPerPage, $role);
        }

        if ($result || $result == []) {
            $this->users_list = $result;
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_USERS_GETUSERS]);
        }
    }

    function page(){
        //error_log('Users::page -> EJECUTO');

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