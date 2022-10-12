<?php

class Session{

    private $sessionName = '';
    private $remember = false;

    public function __construct(){
        if (session_status() == PHP_SESSION_NONE) {

            session_start();
            session_regenerate_id();

            if (isset($_COOKIE['COOKIE_UNDEFINED_SESSION'])){
                if ($_COOKIE['COOKIE_UNDEFINED_SESSION'] == TRUE){
                    $_SESSION[$this->sessionName] = $_COOKIE['COOKIE_DATA_UNDEFINED_SESSION_ID'];
                }
            }
        }

        if(isset($_SESSION["timein"])){
            $sessionTTL = time() - $_SESSION["timein"];

            $timeout = 30*60;

            if($sessionTTL > $timeout){
                $this->closeSession();
            }
        }

    }

    public function setCurrentUser($userID, $remember){
        //error_log('SESSION:: setCurrentUser -> ejecuto');

        $this->remember = $remember;
        if ($remember) {
            setcookie("COOKIE_UNDEFINED_SESSION", TRUE, time()+30*24*60*60, "/");
     
            setcookie("COOKIE_DATA_UNDEFINED_SESSION_ID", $userID, time()+30*24*60*60, "/");
        }

        $_SESSION["timein"] = time();
        $_SESSION[$this->sessionName] = $userID;
    }

    public function getCurrentUser(){
        //if ($this->sessionName != "") 
        return $_SESSION[$this->sessionName];
    }

    public function exists(){
        //error_log('SESSION:: exists -> ejecuto');
        
        return isset($_SESSION[$this->sessionName]);
    }

    public function closeSession(){
        //error_log('SESSION:: closeSession -> ejecuto');
        $e=0;

        if( isset( $_COOKIE['COOKIE_UNDEFINED_SESSION']) ){
            if (!setcookie("COOKIE_UNDEFINED_SESSION", FALSE, time()-99, "/")){
                error_log('SESSION:: closeSession -> COOKIE_UNDEFINED_SESSION FAIL');
                $e++;
            } 
        }

        if( isset( $_COOKIE['COOKIE_DATA_UNDEFINED_SESSION_ID']) ){
            if (!setcookie("COOKIE_DATA_UNDEFINED_SESSION_ID", "", time()-99, "/")){
                error_log('SESSION:: closeSession -> COOKIE_DATA_UNDEFINED_SESSION_ID FAIL');
                $e++;
            } 
        }

        if ($e != 0){
            return "error-cookies";
        }
        else{
            if (!session_unset()) return "error-unset";
            if (!session_destroy()) return "error-destroy";
        }

        return "true";
    }

}

?>
