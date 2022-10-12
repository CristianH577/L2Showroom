//import
import { contact } from './lenguage/lenguage.js';
var text = contact[url['lenguage']];

import { EmergentMessage } from './libs/show-messages.js';
import { InputValidation } from './libs/input-validation.js';
import { ValidateFormatEmail } from './libs/validate-format-mail.js';
//-------------------- -------------------- --------------------

//events
document.querySelectorAll('#form_contact input').forEach(element => {
    element.onblur = function () {
        element.value = element.value.trim();
    }
});

document.getElementById("send").onclick = function () {
    Validate();
}
//-------------------- -------------------- --------------------

//validate
function Validate() {
    const email = document.getElementById('email');
    const from = document.getElementById('name');
    const subject = document.getElementById('subject');
    const messageForm = document.getElementById('contact_message');
    
    if (ValidateEmail(email.value)) {
    if (ValidateName(from.value)) {
    if (ValidateSubject(subject.value)) {
    if (ValidateMessage(messageForm.value)) {
        EmergentMessage('charge');
        document.contact.submit();
    }}}}
}

function ValidateEmail(email) {
    var bool = false;
    if (email == "") {
    }
    else if(ValidateFormatEmail(email)){
        bool = text['code1'];
    }else{
        bool = true;
    }
    InputValidation('email', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}

function ValidateName(name) {
    var bool = false;
    if (name != "") {
        bool = true;
    }
    InputValidation('name', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}

function ValidateSubject(subject) {
    var bool = false;
    if (subject == "") {
    }
    else if (subject.length > 20) {
        bool = text['code2'];
    }
    else {
        bool = true;
    }
    InputValidation('subject', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}

function ValidateMessage(messageForm) {
    var bool = false;
    var words = messageForm.split(" ");
    var wordsSet = new Set(words);

    if (messageForm == "") {
        bool = true;
    }
    else if(messageForm.length < 20 || words.length < 5){
        bool = text['code3'];
    }
    else if(messageForm.length > 1000){
        bool = text['code4'];
    }
    else if(wordsSet.size < 5){
        bool = text['code5'];
    }
    else{
        bool = true;
    }
    InputValidation('contact_message', bool);

    if (bool !== true) {
        bool = false;
    }
    return bool;
}
//-------------------- -------------------- --------------------