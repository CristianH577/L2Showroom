<?php
require_once 'libs/phpMailer/Exception.php';
require_once 'libs/phpMailer/PHPMailer.php';
require_once 'libs/phpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Verify extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Verify::construct -> inicio de Verify');
    }

    function render(){
        //error_log('Verify::render -> Carga el Verify');

        $this->show = "";
        if ($this->existGET(['error'])) {
            $this->show = "resend";
        }else if ($this->existGET(['success'])) {
            $this->show = "login";
        }else{
            $this->validateRegister();
        }

        $this->view->render($this->lenguage, $this->lenguage.'/login/verify', 
        ["user" => $this->user, 
        "lenguage" => $this->lenguage, 
        "show" => $this->show]);
    }

    function setData($lenguage, $page){
        //error_log('Verify::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function existEmail(){
        if($this->existGET(['email'])){
            $email = $this->getGet('email');
            $user = new UserModel();
            
            $verifyEmail = $user->exist("email", $email, 0);
            
            if($verifyEmail){
                $answer = "existEmail";
            }else {
                $answer = "false";
            }
        }else{
            $answer = "error-form";
        }

        echo $answer;
    }

    function validateRegister(){
        //error_log('Verify::validateRegister -> EJECUTO');
        
        if($this->existGET(['email', 'verify'])){
            $email = $this->getGet('email');
            $verify = $this->getGet('verify');

            $user = new UserModel();
            $result = $user->verifyEmail($email, $verify);

            if ($result === TRUE) {

                if ($user->activateAccount($email)) {
                    $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_VERIFY_VALIDATE_REGISTER]);
                }else{
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_VALIDATE_ACTIVATE]);
                }

            }else if ($result == "already") {
                $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_VERIFY_VALIDATE_ALREADY]);
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_VALIDATE]);
            }
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_VALIDATE_LINK]);
        }
    }

    function resendVerifyLink(){
        //error_log('Verify::resendVerifyLink -> EJECUTO');

        if($this->existGET(['email'])){
            $email = $this->getGet('email');
            
            $user = new UserModel();
            $result = $user->resendVerify($email);

            if ($result) {
                $verify = $result;

                $link = constant("URL").$this->route."?email=$email&verify=$verify";
                
                switch ($this->lenguage) {
                    case 'es':
                        $subject = "Registro | Verificacion";
                        $body = "
                        <p>Haga clic en este enlace para activar su cuenta:</p>
                        <a href='$link'>Click aqui</a>";
                        $bodyAlt = "Ingrese en este enlace para activar su cuenta: $link";
                        break;
                    case 'en':
                        $subject = "Signup | Verification"; 
                        $body = "
                        <p>Please click this link to activate your account:</p>
                        <a href='$link'>Click here</a>";
                        $bodyAlt = "Enter this link to activate your account: $link";
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
                    $mailer->Username   = 'random@gmail.com';
                    $mailer->Password   = 'password';
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
                        $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_VERIFY_RESEND]);
                    }else{
                        //error_log('Signup::sendVerifyLink -> Error al enviar verify');
                        $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_RESEND]);
                    }
                } catch (Exception $e) {
                    error_log('Contact::sendMail ->phpmailerException '.$mailer->ErrorInfo);
                }
            }else{
                $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_RESEND_CODE]);
            }
            
        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_VERIFY_RESEND_FORM]);
        }
    }
}

?>
