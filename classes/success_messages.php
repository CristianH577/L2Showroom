<?php

class SuccessMessages{

    const TEST = "TEST";
    const SUCCESS_ADMIN_DELETE_USER = "MFctbaxi0eJFimMQ13S48OVvueUvogKe6h3.oNkI5bleGB2Myxdey";
    const SUCCESS_ADMIN_DELETE_ORDER = "o5FNZ89Qp8S2xalZJ1.6XO..xA3KykrJEVDniulZEajdxjO0Rv9z2";
    const SUCCESS_ADMIN_DELETE_ITEM = "nc4p2kodZp1ehpdzCamL0.BMSbUu0THeRmDpQ6jcryEOXB.WlTIQu";
    const SUCCESS_CONTACT_SENDMAIL = "CCKzkhR1UTo1uv7EoKhtwugBYDQ9rFm3mPL9eadDHpERbRshule.S";
    const SUCCESS_DASHBOARD_UPDATE = "4yjDlqKSabmGPGT88OYwauVxRgGUzDwFIhVQONa2yJcWbZKj.UIjC";
    const SUCCESS_DASHBOARD_DELETE_ACCOUNT = "jsMLEQYrGw4ScLoESZ3ySe13Jxs02yMj4reMgxdKOJQ6eK2g0oYWO";
    const SUCCESS_ITEMS_NEWITEM = "EJFqhEqDoFoUUF2epoaHeOwIAmLFV8CJpSpHYdP1lMFO3RpzWnJim";
    const SUCCESS_MYSTORE_NEWORDER = "KsU0CR1n3B8XHRvQPqqwiOAUvrrDARnUmj1Jean86BBV.jf1EpxzG";
    const SUCCESS_MYSTORE_DELETE = "t1SKe6JnMvN7Ss1Bfwqz3.yRaSngbwGnTC.08YeCdS3M.TH.AeWa6";
    const SUCCESS_SIGNUP_NEWUSER = "1gMVAgHbCX.PKiK8qFv6PumFy0sIz.druBW.W2DbWDqpgXYv.djUe";
    const SUCCESS_VERIFY_VALIDATE_REGISTER = "c5RgmMPoGNqcve1iZ4yAsuJ6MpMyd6GI4ZW5iY3oB5NHKdYGxRv9i";
    const SUCCESS_VERIFY_VALIDATE_ALREADY = ".jqEggMpNf3MFCT0cdEFtOtYWP21Y64Fyfc5zlVxRCXqk5NUXSkXO";
    const SUCCESS_VERIFY_RESEND = "rHyr.5oD1IftlkLV6uyCOuPuldb891BnDrGDxAdnOzAifLxujoe96";

    private $successListES = [];
    private $successListEN = [];

    public function __construct(){
        $this->successListES = [
            SuccessMessages::TEST => "TEST",
            
            SuccessMessages::SUCCESS_ADMIN_DELETE_USER => "Usuario eliminado",
            SuccessMessages::SUCCESS_ADMIN_DELETE_ORDER => "Orden eliminada",
            SuccessMessages::SUCCESS_ADMIN_DELETE_ITEM => "Item eliminado",
            SuccessMessages::SUCCESS_CONTACT_SENDMAIL => "Mensaje enviado. Sera respondido en breve.",
            SuccessMessages::SUCCESS_DASHBOARD_UPDATE => "Cambios guardados",
            SuccessMessages::SUCCESS_DASHBOARD_DELETE_ACCOUNT => "Su cuenta ha sido eliminada correctamente.",
            SuccessMessages::SUCCESS_ITEMS_NEWITEM => "Objeto registrado",
            SuccessMessages::SUCCESS_MYSTORE_NEWORDER => "Orden agregada",
            SuccessMessages::SUCCESS_MYSTORE_DELETE => "Orden eliminada",
            SuccessMessages::SUCCESS_SIGNUP_NEWUSER => "Nuevo usuario registrado correctamente. Revise su correo para activar su cuenta.",
            SuccessMessages::SUCCESS_VERIFY_VALIDATE_REGISTER => "Email verificado.",
            SuccessMessages::SUCCESS_VERIFY_VALIDATE_ALREADY => "Cuenta ya activada.",
            SuccessMessages::SUCCESS_VERIFY_RESEND => "Verificacion reenviada. Revise su correo para activar su cuenta.",
        ];
        $this->successListEN = [
            SuccessMessages::TEST => "TEST",

            SuccessMessages::SUCCESS_ADMIN_DELETE_USER => "Deleted User",
            SuccessMessages::SUCCESS_ADMIN_DELETE_ORDER => "Order deleted",
            SuccessMessages::SUCCESS_ADMIN_DELETE_ITEM => "Item deleted",
            SuccessMessages::SUCCESS_CONTACT_SENDMAIL => "Message sent. Will be answered shortly.",
            SuccessMessages::SUCCESS_DASHBOARD_UPDATE => "Changes Saved",
            SuccessMessages::SUCCESS_DASHBOARD_DELETE_ACCOUNT => "Your account has been successfully deleted.",
            SuccessMessages::SUCCESS_ITEMS_NEWITEM => "Registered Item",
            SuccessMessages::SUCCESS_MYSTORE_NEWORDER => "Order Added",
            SuccessMessages::SUCCESS_MYSTORE_DELETE => "Order deleted",
            SuccessMessages::SUCCESS_SIGNUP_NEWUSER => "New user successfully registered. Check your email to activate your account.",
            SuccessMessages::SUCCESS_VERIFY_VALIDATE_REGISTER => "Email verified.",
            SuccessMessages::SUCCESS_VERIFY_VALIDATE_ALREADY => "Account already activated.",
            SuccessMessages::SUCCESS_VERIFY_RESEND => "Verification resend. Please check your email to activate your account.",
        ];
    }

    public function get($lenguage, $hash){
        switch ($lenguage) {
            case 'es':
                return $this->successListES[$hash];
                break;
            case 'en':
                return $this->successListEN[$hash];
                break;
            
            default:
                # code...
                break;
        }
    }
    
    public function existKey($lenguage, $key){
        switch ($lenguage) {
            case 'es':
                $successList = $this->successListES;
                break;
            case 'en':
                $successList = $this->successListEN;
                break;
            
            default:
                # code...
                break;
        }

        if(array_key_exists($key, $successList)){
            return true;
        }else{
            return false;
        }
    }
    
}

?>