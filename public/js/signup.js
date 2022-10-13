//import
import { signup } from './lenguage/lenguage.js';
var text = signup[url['lenguage']];

import { HttpRequest } from './libs/http-request.js';
import { InputValidation } from './libs/input-validation.js';
import { Preview } from './libs/preview.js';
import { ShowMessages, EmergentMessage } from './libs/show-messages.js';
import { ShowPassword } from './libs/show-password.js';
import { ValidateFormatEmail } from './libs/validate-format-mail.js';
//-------------------- -------------------- --------------------

//vars
const email = document.getElementById('email');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');
const nick = document.getElementById('nick');
//-------------------- -------------------- --------------------

//events
email.onblur = function() {
    email.value = email.value.trim();
    ValidateEmail(email.value.trim());
}
password.onblur = function() {
    ValidatePassword(password.value);
}
confirmPassword.onblur = function() { 
    ValidateConfirmPassword(password.value, confirmPassword.value);
    
}
nick.onblur = function() {
    nick.value = nick.value.trim();
    ValidateNick(nick.value);
}

document.getElementById("register").onclick = function () {
    Validate();
}
document.querySelectorAll('.password svg').forEach(element => {
    element.onclick = function () {
        ShowPassword(element.dataset.id);
    }
});
//-------------------- -------------------- --------------------

//validates
function ValidateEmail(email) {
    var bool = false;
    if (email == "") {
    }
    else if(ValidateFormatEmail(email)){
        bool = text['code1'];
    }
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
    }
    /*else if(password.length > 16 || password.length < 8){
        bool = text['code2'];
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
function ValidateConfirmPassword(password, confirm) {
    var bool = false;
    if (password != "") {
        if (confirm == "") {
        }else 
        if(password != confirm){
            bool = text['code3'];
        }else{
            bool = true;
        }
        InputValidation('confirm_password', bool);
    }

    if (bool !== true) {
        bool = false;
    }
    return bool;
}
function ValidateNick(nick) {
    var bool = false;
    if (nick != "") {
        bool = true;
    }
    InputValidation('nick', bool);

    return bool;
}

function Validate(){
    if (ValidateEmail(email.value)) {
    if (ValidatePassword(password.value)) {
    if (ValidateConfirmPassword(password.value, confirmPassword.value)) {
    if (ValidateNick(nick.value)) {
        HttpRequest("signup/validateNewUser?email=" + email.value + "&nick=" + nick.value , function(){
      
            var answer = this.responseText.trim();
            var message;
      
            switch (answer) {
              case "existEmail":
                message = text['code4'];
                InputValidation('email', message);
                break;
                
              case "existNick":
                message = text['code5'];
                InputValidation('nick', message);
                break;
      
              case "true":
                EmergentMessage('charge');
                document.signup.submit();
                break;
      
              case "error-form":
                message = text['code6'];
                ShowMessages(message);
                break;
            
              default:
                message = text['code7'];
                ShowMessages(message);
                break;
            }
    
        });
    }}}}
    
}
//-------------------- -------------------- --------------------

//pre view
const inputID = "new_profile_img";
var srcDefault = document.querySelector("#"+inputID+"_label img").src;
const input = document.getElementById(inputID);
input.addEventListener('change', function () { 
    Preview(inputID, srcDefault); 
});
//-------------------- -------------------- --------------------

//reset
document.getElementById("clean").onclick = function () {
    Clean();
}
function Clean() {
    var inputs = document.querySelectorAll("#signup input");

    for (let index = 0; index < inputs.length; index++) {
        ShowMessages("");
        inputs[index].value = "";
        if (inputs[index].type != "file") {
            InputValidation(inputs[index].id, true);
        }
    }
    Preview(inputID, srcDefault);

    document.querySelectorAll('.password input').forEach(element => {
        if (element.type == "text") ShowPassword(element.id);
    });
}
//-------------------- -------------------- --------------------

//user random
if (!!document.getElementById("random")) {
    document.getElementById("random").onclick = function () {
        UserRandom();
    }
}
function UserRandom() {
    const num = 3;
    var random = "user" + num;

    email.value = random+"@mail.com";
    password.value = num;
    confirmPassword.value = num;
    nick.value = "UserRamdom"+num;
    discord.value = "#UserRamdom"+Math.floor(Math.random()*10000);
}
//-------------------- -------------------- --------------------