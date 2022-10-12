<?php
require_once 'libs/phpMailer/Exception.php';
require_once 'libs/phpMailer/PHPMailer.php';
require_once 'libs/phpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Signup extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Signup::construct -> inicio de signup');
    }

    function render(){
        //error_log('Signup::render -> Carga el signup');

        $this->view->render($this->lenguage, $this->lenguage.'/login/signup', 
        ["user" => $this->user, 
        "lenguage" => $this->lenguage]);
    }

    function setData($lenguage, $page){
        //error_log('Signup::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function validateNewUser(){
        //error_log('Signup::validateNewUser -> Ejecuta');

        if ($this->existGET(['email', 'nick'])) {
            $email = $this->getGet('email');
            $nick = $this->getGet('nick');

            $user = new UserModel();

            $verifyEmail = $user->exist("email", $email, 0);
            $verifyNick = $user->exist("nick", $nick, 0);

            if($verifyEmail){
                $answer = "existEmail";
            }
            else if($verifyNick){
                $answer = "existNick";
            }
            else{
                $answer = "true";
            }

        }else{
            $answer = "error-form";
        }

        echo $answer;

    }

    function newUser(){
        //error_log('Signup::newUser -> Ejecuta');
        
        if($this->existPOST(['email', 'password', 'nick', 'discord'])){

            $email = $this->getPost('email');
            $password = $this->getPost('password');
            $nick = $this->getPost('nick');

            $discord = $this->getPost('discord');
            if ($discord == "") {
                $discord = "-";
            }

            $date = new DateTime();
            //$date->setTimezone(new DateTimeZone('Europe/Amsterdam'));  
            $date_register = $date->format("Y-m-d h:i:s a");

            $verify = md5( rand(0,1000) );
            
            $user = new UserModel();
            $user->setEmail($email);
            $user->setPassword($password, false);
            $user->setNick($nick);
            $user->setRole("user");
            $user->setDiscord($discord);
            $user->setDate($date_register);
            $user->setVerify($verify);
            $user->setActive("0");

            if($user->save()){
                $this->sendVerifyLink($email, $password, $verify);

                $result = $user->exist("email", $email, 0);
                if ($result) {
                    $id = $result->getID();
                    $user->setID($id);
    
                    if (isset($_FILES['new_profile_img']) && $_FILES['new_profile_img']['name'] != "") {
                        $new_profile_img = $_FILES['new_profile_img']['name'];
        
                        $new_profile_img_temp = $_FILES['new_profile_img']['tmp_name'];
                        $directorio = "assets/profiles/" ;
                        $extension = pathinfo($new_profile_img, PATHINFO_EXTENSION);
                        $profile_img = $id.".".$extension;
                        $profile_img_path = $directorio.$profile_img;
        
                        if(!move_uploaded_file($new_profile_img_temp, $profile_img_path)){
                            //$this->redirect($this->route, ['error' => ErrorsMessages::ERROR_SIGNUP_NEWUSER_MOVE_IMG]);
                            error_log('Signup::newUser -> Hubo un error al archivar la imagen de perfil');
                            $profile_img = "default.jpg";
                        }
                    }else{
                        $profile_img = "default.jpg";
                    }
        
                    $user->setImg($profile_img);
    
                    if(!$user->updateImg()){
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_SIGNUP_UPDATE_IMG]);
                    }
    
                    $this->redirect($this->lenguage.'/login', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
                }
                else{
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_SIGNUP_NEWUSER_IMG_ID]);
                }
                
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_SIGNUP_NEWUSER]);
            }

        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_SIGNUP_NEWUSER_FORM]);
        }
    }

    function sendVerifyLink($email, $password, $verify){
        //error_log('Signup::sendVerifyLink -> Ejecuta');

        $link = constant("URL").$this->lenguage."/verify?email=$email&verify=$verify";

        switch ($this->lenguage) {
            case 'es':
                $subject = "Registro | Verificacion"; 

                $body = "
                <h1>Gracias por registrarse!</h1>
                <p>Tu cuenta ha sido creada,puede iniciar sesión con las siguientes credenciales después de haber activado su cuenta presionando el link a continuación.</p>
                <p>------------------------</p>
                <h2p>Email: $email</h2>
                <h2>Contraseña: $password</h2>
                <p>------------------------</p>
                <p>Haga clic en este enlace para activar su cuenta:</p>
                <a href='$link'>Click Aqui</a>";

                $bodyAlt = "
                Gracias por registrarse!
                Tu cuenta ha sido creada,puede iniciar sesión con las siguientes credenciales después de haber activado su cuenta presionando el link a continuación.
                ------------------------
                Email: $email
                Contraseña: $password
                ------------------------
                Ingrese en este enlace para activar su cuenta:
                $link";
                break;
                
            case 'en':
                $subject = "Signup | Verification"; 

                $body = "
                <h1>Thanks for signing up!</h1>
                <p>Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.</p>
                <p>------------------------</p>
                <h2p>Email: $email</h2>
                <h2>Password: $password</h2>
                <p>------------------------</p>
                <p>Please click this link to activate your account:</p>
                <a href='$link'>Click here</a>";

                $bodyAlt = "
                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                
                ------------------------
                Email: '.$email.'
                Password: '.$password.'
                ------------------------
                
                Enter this link to activate your account:
                $link";
                break;
            
            default:
                # code...
                break;
        }

        try {
            $mailer = new PHPMailer(true);

            $mailer->isSMTP();
            $mailer->Host       = 'smtp.gmail.com';
            $mailer->SMTPAuth   = true;
            $mailer->Username   = 'cristianh212019@gmail.com';
            $mailer->Password   = 'toneydkgeecpunku';
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       
            $mailer->Port       = 465;   

            //Recipients
            $mailer->setFrom("L2Showroom@site.com", "L2 Showroom");
            $mailer->addAddress($email);

            //Content
            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body    = $body;
            $mailer->AltBody = $bodyAlt;
            $mailer->CharSet = 'UTF-8';

            if ($mailer->send()) {
                //error_log('Signup::sendVerifyLink -> Verify enviado');
                //$this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_CONTACT_SENDMAIL]);
            }else{
                error_log('Signup::sendVerifyLink -> Error al enviar verify');
                //$this->redirect($this->route, ['error' => ErrorsMessages::ERROR_CONTACT_SENDMAIL]);
            }
        } catch (Exception $e) {
            error_log('Contact::sendMail ->phpmailerException '.$mailer->ErrorInfo);
        }
    }
}

?>