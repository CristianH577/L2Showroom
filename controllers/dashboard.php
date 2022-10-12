<?php
class Dashboard extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Dashboard::construct -> inicio de dashboard');
    }

    function render(){
        //error_log('Dashboard::render -> Carga el index de dashboard');

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

    function validateChanges(){
        //error_log('Dashboard::validateChanges -> Ejecuta');

        if($this->existGET(['id', 'email', 'nick'])){
            $id = $this->getGet('id');
            $email = $this->getGet('email');
            $nick = $this->getGet('nick');
            $discord = $this->getGet('discord');

            $user = new UserModel();

            $verifyEmail = $user->exist("email", $email, $id);
            $verifyNick = $user->exist("nick", $nick, $id);
            $verifyDiscord = $user->exist("discord", $discord, $id);

            if($verifyEmail){
                $answer = "exist-email";
            }
            else if($verifyNick){
                $answer = "exist-nick";
            }
            else if($verifyDiscord){
                $answer = "exist-discord";
            }
            else{
                $answer = "true";
            }

        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function updateChanges(){
        //error_log('Dashboard::updateChanges -> Ejecuta');
        
        if($this->existPOST(['id', 'email', 'nick', 'discord', 'new_password', 'password', 'action_img'])){
            $id = $this->getPost('id');
            $email = $this->getPost('email');
            $password = $this->getPost('password');
            $nick = $this->getPost('nick');
            $discord = trim($this->getPost('discord'));
            if ($discord == "") {
                $discord = "-";
            }
            $new_password = $this->getPost('new_password');
            $action_img = $this->getPost('action_img');
            
            $user = new UserModel();
            
            $comparePasswords = $user->comparePasswords($password, $id);

            if ($comparePasswords === true) {
                $user->setID($id);
                $user->setEmail($email);
                $user->setNick($nick);
                $user->setDiscord($discord);
                if ($new_password != "") {
                    $user->setPassword($new_password, false);
                }else{
                    $user->setPassword($password, false);
                }

                if ($action_img != "") {
                    if (!$user->deleteOldImg($id)) {
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE_DELETE_OLDIMG]);
                    }
    
                    if ($action_img == "delete") {
                        $profile_img = "default.jpg";
                    }
    
                    if ($action_img == "change") {
                        $new_profile_img = $_FILES['new_profile_img']['name'];
        
                        $new_profile_img_temp = $_FILES['new_profile_img']['tmp_name'];
                        $directorio = "assets/profiles/" ;
                        $extension = pathinfo($new_profile_img, PATHINFO_EXTENSION);
                        $profile_img = $id.".".$extension;
                        $profile_img_path = $directorio.$profile_img;
        
                        if(!move_uploaded_file($new_profile_img_temp, $profile_img_path)){
                            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE_MOVE_IMG]);
                        }
                    }
                    
                    $user->setImg($profile_img);
    
                    if(!$user->updateImg()){
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE_CHANGE_IMG]);
                    }
                }

                if($user->update()){
                    $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_DASHBOARD_UPDATE]);
                }else{
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE]);
                }

            }
            else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE_PASSWORD_INCORRECT]);
            }

        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_UPDATE_FORM]);
        }
    }

    function deleteAccount(){
        //error_log('Dashboard::deleteAccount -> Ejecuta');

        if($this->existPOST(['delete_user'])){
            $id = $this->getPost('delete_user');
            $user = new UserModel();

            if (!$user->deleteOldImg($id)) {
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_DELETE_ACCOUNT_IMG]);
            }

            if ($user->delete($id)) {
                $this->logout();
                $this->redirect($this->lenguage.'/login', ['success' => SuccessMessages::SUCCESS_DASHBOARD_DELETE_ACCOUNT]);
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_DELETE_ACCOUNT]);
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_DASHBOARD_DELETE_ACCOUNT_FORM]);
        }
        
    }
       
}
?>