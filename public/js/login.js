//import
import { login } from './lenguage/lenguage.js';
var text = login[url['lenguage']];

import { ShowPassword } from './libs/show-password.js';
import { ValidateFormatEmail } from './libs/validate-format-mail.js';
import { InputValidation } from './libs/input-validation.js';
//-------------------- -------------------- --------------------

//var
const email = document.getElementById('email');
const password = document.getElementById('password');
//-------------------- -------------------- --------------------

//events
document.getElementById("svg_password").onclick = function () {
    ShowPassword("password");
}
email.onblur = function() { 
    if (email.value != "") {
        email.value = email.value.trim();
        InputValidation('email', true);
    }
}
password.onblur = function() { 
    if (password.value != "") {
        email.value = email.value.trim();
        InputValidation('password', true);
    }
}
document.getElementById("log").onclick = function () {
    Validate();
}
//-------------------- -------------------- --------------------


//validates
function ValidateEmail(email) {
    var bool = false;
    if (email == "") {
        bool = text['code1'];
    } 
    /*else if(ValidateFormatEmail(email)){
        bool = text['code2'];
    }*/
    else{
        bool = true;
    }
    InputValidation('email', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}
function ValidatePassword(password) {
    var bool = false;
    if (password == "") {
        bool = text['code3'];
    }
    /*else if(password.length > 16 || password.length < 8){
        bool = text['code4'];
    }*/
    else{
        bool = true;
    }
    InputValidation('password', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}

function Validate(){
    if (ValidateEmail(email.value)) {
    if (ValidatePassword(password.value)) {
        document.login.submit();
    }}
}
//-------------------- -------------------- --------------------