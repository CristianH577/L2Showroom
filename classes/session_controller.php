<?php
require_once 'classes/session.php';
require_once 'models/usermodel.php';

class SessionController extends Controller{
    
    private $userSession;
    private $username;
    private $userid;

    private $session;
    private $sites;

    private $user;
    private $lenguage;
 
    function __construct(){
        parent::__construct();

        $this->init();
    }

    public function getUserSession(){
        return $this->userSession;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getUserId(){
        return $this->userid;
    }

    private function init(){
        $this->session = new Session();
        $json = $this->getJSONFileConfig();
        $this->sites = $json['sites'];
        $this->defaultSites = $json['default-sites'];
        $this->validateSession();
    }

    private function getJSONFileConfig(){
        $string = file_get_contents("config/access.json");
        $json = json_decode($string, true);

        return $json;
    }

    function validateSession(){
        //error_log('SESSIONCONTROLLER::validateSession()');

        if($this->existsSession()){
            $role = $this->getUserSessionData()->getRole();

            if($this->isPublic()){
                $currentPage = $this->getCurrentPage();

                if ( $currentPage == "login" || $currentPage == "signup" || strpos($currentPage, "verify") !==false ) {
                    $this->redirectDefaultSiteByRole($role);
                }
            }else{
                if($this->isAuthorized($role)){
                    //error_log( "SessionController::validateSession() => authorized" );
                }else{
                    $this->redirectDefaultSiteByRole($role);
                }
            }
        }else{
            if($this->isPublic()){
            }else{
                header('location: '. constant('URL') . '');
            }
        }
    }

    function existsSession(){
        //error_log('SessionController::existsSession()');

        if(!$this->session->exists()) return false;
        
        $userid = $this->session->getCurrentUser();
        if($userid == NULL) return false;

        if($userid) return true;

        return false;
    }

    function getUserSessionData(){
        $id = $this->session->getCurrentUser();

        $this->user = new UserModel();
        $this->user->getUser($id);
        return $this->user;
    }

    private function isPublic(){
        $currentURL = $this->getCurrentPage();
        $e = false;

        $currentURL = preg_replace( "/\?.*/", "", $currentURL);

        for($i = 0; $i < sizeof($this->sites); $i++){
            if ($currentURL === $this->sites[$i]['site']) {
                if ($this->sites[$i]['access'] === 'public') {
                    return true;
                }
                $e = true;
            }
        }
        if ($e) {
            return false;
        }else{
            return true;
        }
    }

    private function getCurrentPage(){
        $actual_link = trim($_SERVER['REQUEST_URI']);
        $url = explode('/', $actual_link);

        if (!empty($url[2])) {
            $this->lenguge = $url[2];
        }

        if (!empty($url[3])) {
            //error_log("sessionController::getCurrentPage(): actualLink =>" . $actual_link . ", url => " . $url[3]);

            return $url[3];
        }

        return "";
    }

    private function redirectDefaultSiteByRole($role){
        $url = '';
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($this->sites[$i]['role'] === $role){
                $url = $this->sites[$i]['site'];
            break;
            }
        }
        header('Location: ' . constant('URL'). $this->lenguge .'/' . $url);
        
    }

    private function isAuthorized($role){
        $currentURL = $this->getCurrentPage();
        $currentURL = preg_replace( "/\?.*/", "", $currentURL);
        
        for($i = 0; $i < sizeof($this->sites); $i++){
            if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['role'] === $role){
                return true;
            }
        }
        return false;
    }

    function authorizeAccess($role){
        switch($role){
            case 'user':
                $this->redirect($this->lenguge.'/'.$this->defaultSites['user'], []);
            break;
            case 'admin':
                $this->redirect($this->lenguge.'/'.$this->defaultSites['admin'], []);
            break;
            default:
        }
    }

    function initialize($user, $remember){
        //error_log("sessionController::initialize(): user: " . $user->getEmail());
        //error_log("sessionController::initialize(): role: " . $user->getRole());
        
        $this->session->setCurrentUser($user->getId(), $remember);
        $this->authorizeAccess($user->getRole());
    }

    function logout(){
        $close = $this->session->closeSession();

        switch ($close) {
            case "true":
                $this->redirect($this->lenguge."/login", []);
                break;
            case 'error-cookies':
                $this->redirect($this->lenguge."/login", ['error' => ErrorsMessages::ERROR_SESSION_CONTROLLER_LOGOUT_COOKIE]);
                break;
            case 'error-unset':
                $this->redirect($this->lenguge."/login", []);
                //$this->redirect($this->lenguge."/login", ['error' => ErrorsMessages::ERROR_SESSION_CONTROLLER_LOGOUT_UNSET]);
                break;
            case 'error-destroy':
                $this->redirect($this->lenguge."/login", ['error' => ErrorsMessages::ERROR_SESSION_CONTROLLER_LOGOUT_DESTROY]);
                break;
            
            default:
                $this->redirect($this->lenguge."/login", ['error' => ErrorsMessages::ERROR_SESSION_CONTROLLER_LOGOUT]);
                break;
        }
            
    }
    
}

?>
