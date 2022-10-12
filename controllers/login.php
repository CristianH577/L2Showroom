<?php
class Login extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Login::construct -> inicio de login');
    }

    function render(){
        //error_log('Login::render -> Carga el index de login');
        $this->view->render($this->lenguage, $this->route.'/index', 
        ["user" => $this->user, 
        "lenguage" => $this->lenguage]);
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

    function authenticate(){
        //error_log('Login::authenticate()-> EJECUTO');  
        
        if( $this->existPOST( ['email', 'password']) ){
            $email = $this->getPost('email');
            $password = $this->getPost('password');

            if ($this->existPOST( ['remember_user'] )) {
                $remember_user = true;
            }else{
                $remember_user = false;
            }

            $user = new UserModel();
            $result = $user->exist("email", $email, 0);
 
            if ($result) {
                if ($result->getActive() == 0) {
                    $this->redirect($this->lenguage.'/verify', ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_NOTVERIFY]);
                }else{
                    if ($user->comparePasswords($password, $result->getID())) {
                        $this->initialize($result, $remember_user);
                    }else{
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_PASSWORD_INCORRECT]);
                    }
                }
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_NO_EXIST]);
            }

        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_LOGIN_AUTHENTICATE_FORM]);
        }
    }
    
}
?>