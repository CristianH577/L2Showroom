<?php
require_once 'libs/phpMailer/Exception.php';
require_once 'libs/phpMailer/PHPMailer.php';
require_once 'libs/phpMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Contact extends SessionController{

    function __construct(){
        parent::__construct();
        //error_log('Contact::construct -> inicio de contacto');
    }

    function render(){
        //error_log('Contact::render -> Carga el index de contacto');
        
        $this->view->render($this->lenguage, $this->route.'/index', 
        ["user" => $this->user, 
        "lenguage" => $this->lenguage]);
    }

    function setData($lenguage, $page){
        //error_log('Contact::setData -> EJECUTO');
        
        $this->lenguage = $lenguage;
        $this->page = $page;
        $this->route = $lenguage.'/'.$page;

        if ($this->existsSession()) {
            $this->user = $this->getUserSessionData();
        }else{
            $this->user = "";
        }
    }

    function sendMail(){
        //error_log('Contact::sendMail -> EJECUTO');
        
        if($this->existPOST(['email', 'name', 'subject', 'contact_message'])){
            $email = $this->getPost('email');
            $name = $this->getPost('name');
            $subject = $this->getPost('subject');
            $contact_message = $this->getPost('contact_message');

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
                $mailer->setFrom($email, $name);
                $mailer->addAddress('they13@hotmail.com', 'L2Showroom');

                //Content
                $mailer->isHTML(true);
                $mailer->Subject = $subject;
                $mailer->Body    = "<h1>$subject</h1><p>$contact_message</p>";
                $mailer->AltBody = $subject.": ".$contact_message;
                $mailer->CharSet = 'UTF-8';
    
                if ($mailer->send()) {
                    $this->redirect($this->route, ['success' => SuccessMessages::SUCCESS_CONTACT_SENDMAIL]);
                }else{
                    $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_CONTACT_SENDMAIL]);
                }
            } catch (Exception $e) {
                error_log('Contact::sendMail ->phpmailerException '.$mailer->ErrorInfo);
            }

        }else{
            $this->redirect($this->route, ['error' => ErrorsMessages::ERROR_CONTACT_SENDMAIL_FORM]);
        }
    }
    
}
?>
