//import
import { verify } from './lenguage/lenguage.js';
var text = verify[url['lenguage']];

import { HttpRequest } from './libs/http-request.js';
import { InputValidation } from './libs/input-validation.js';
import { ShowMessages } from './libs/show-messages.js';
import { ValidateFormatEmail } from './libs/validate-format-mail.js';
//-------------------- -------------------- --------------------

//vars
const email = document.getElementById('email');
//-------------------- -------------------- --------------------

//events
if (!!email) {
    email.onblur = function () {
        email.value = email.value.trim();
        if (email.value != "") {
            InputValidation('email', true);
        }
    }
}

document.getElementById("validate").onclick = function () {
    Validate();
}
//-------------------- -------------------- --------------------

//validates
function Validate() {
    var bool = false;
    if (email.value == "") {
        bool = text['code1'];
    }else if(ValidateFormatEmail(email.value)){
        bool = text['code2'];
    }else{
        bool = true;
        ExistEmail(email.value);
    }
    InputValidation('email', bool);
}

function ExistEmail(email) {
    HttpRequest("verify/existEmail?email=" + email , function(){

        var answer = this.responseText;
        var message;

        switch (answer) {
            case "existEmail":
                document.form_verify.submit();
                break;
            case "false":
                message = text['code3'];
                InputValidation('email', message);
                break;
            
            default:
                message = text['code4'];
                ShowMessages(message);
                break;
        }
    });
}
//-------------------- -------------------- --------------------