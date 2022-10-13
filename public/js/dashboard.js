//import
import { dashboard } from './lenguage/lenguage.js';
var text = dashboard[url['lenguage']];

import { HttpRequest } from './libs/http-request.js';
import { InputValidation } from './libs/input-validation.js';
import { Preview } from './libs/preview.js';
import { ShowMessages } from './libs/show-messages.js';
import { ShowPassword } from './libs/show-password.js';
import { ValidateFormatEmail } from './libs/validate-format-mail.js';
//-------------------- -------------------- --------------------

//events
document.querySelectorAll(".password svg").forEach(element => {
  element.onclick = function () {
    ShowPassword(element.dataset.id);
  }
});
//-------------------- -------------------- --------------------

//vars
var changeData = document.querySelector("#change_data");
var form = document.querySelector("#form_update");
var formInputs = document.querySelectorAll("#form_update input");
var actions = document.getElementById("actions");
var actions_profile_img = document.getElementById("actions_profile_img");

var id = document.getElementById("id");
var email = document.getElementById("email");
var nick = document.getElementById("nick");
var discord = document.getElementById("discord");
var action_img = document.getElementById("action_img");
var new_password = document.getElementById("new_password");
var confirm_new_password = document.getElementById("confirm_new_password");
var password = document.getElementById("password");

var changeDataH = changeData.getBoundingClientRect().height;
//-------------------- -------------------- --------------------

//events
changeData.style.height = 0;

window.addEventListener('resize', function () {
  if ( actions.getBoundingClientRect().height <= 0 ) {
    Cancel();
  }
  changeData.style.height = "unset";
  changeDataH = changeData.getBoundingClientRect().height;
  changeData.style.cssText = "polygon(0 0, 100% 0, 100% 0, 0 0);";
  changeData.style.height = 0;
});

formInputs.forEach(element => {
    element.onblur = function () {
      if (element.type != "file") {
        element.value = element.value.trim();
        if (element.value != "") {
          InputValidation(element.id, true);
        }
      }
    }
});

Disabled(true);
//-------------------- -------------------- --------------------

//disabled inputs
function Disabled(boolean) {
  var inputStyle;
  
  if (boolean == true) {
    inputStyle = "border: none; background: none; box-shadow: none;";
  }
  else if (boolean == false) {
    inputStyle = "border: 1px solid #704c24; background: var(--background); box-shadow: 4px 4px 4px black;";

  }

  formInputs.forEach(element => {
    if (element.type != "button") {
      element.disabled = boolean;
      element.style.cssText = inputStyle;
    }
  });
}
//-------------------- -------------------- --------------------

//edit
document.getElementById("edit").onclick = function() { Edit(); };

function Edit() {
  actions_profile_img.style.display = "flex";
  actions.style.display = "none";

  Disabled(false);
  
  changeData.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); height: unset;";
  let start = Date.now();

  let timer = setInterval(function() {
    let timePassed = Date.now() - start;

    changeData.style.height = timePassed  + 'px';

    if (timePassed > changeDataH) {
      clearInterval(timer);
      changeData.style.height = 'unset';
    }

  }, 20);
}
//-------------------- -------------------- --------------------

//reset
document.getElementById("resetForm").onclick = function(e) { ResetForm(); };

function ResetForm() {
  formInputs.forEach(element => {
    if (element.type != "file") {
      InputValidation(element.id, true);
    }
  });
  
  document.querySelectorAll('.password input').forEach(element => {
    if (element.type == "text") ShowPassword(element.id);
  });

  ShowMessages("");
  if (document.getElementById("action_img").value != "") {
    ResetImg();
  }
  form.reset();
}
//-------------------- -------------------- --------------------

//cancel
document.getElementById("cancel").onclick = function() { Cancel(); };

function Cancel() {
  actions_profile_img.style.display = "none";
  actions.style.display = "flex";

  changeData.style.cssText = "polygon(0 0, 100% 0, 100% 0, 0 0);";
  let start = Date.now();

  let timer = setInterval(function() {
    let timePassed = Date.now() - start;
    changeData.style.height = changeDataH - (timePassed ) + 'px';
    if (timePassed > changeDataH) {
      clearInterval(timer);
      changeData.style.height = 0;
    };
  }, 20);

  ResetForm();

  Disabled(true);
}
//-------------------- -------------------- --------------------

//update
document.getElementById("update").onclick = function(e) { Update(); };

function Update() {
  if (ValidateEmail(email.value.trim())) {
  if (ValidateNick(nick.value.trim())) {
  if (ValidateNewPassword(new_password.value.trim())) {
  if (ValidateConfirmNewPassword(new_password.value, confirm_new_password.value)) {
  if (ValidatePassword(password.value)) {
    HttpRequest("dashboard/validateChanges?id=" + id.value + "&email=" + email.value + "&nick=" + nick.value + "&discord=" + discord.value , function(){
      
      var answer = this.responseText.trim();
      var message;

      switch (answer) {
        case "error-form":
          message = text['code1'];
          ShowMessages(message);
          break;

        case "exist-email":
          message = text['code2'];
          InputValidation('email', message);
          break;
          
        case "exist-nick":
          message = text['code3'];
          InputValidation('nick', message);
          break;
          
        case "exist-discord":
          message = text['code4'];
          InputValidation('nick', message);
          break;

        case "true":
          document.form_update.submit();
          break;
      
        default:
          message = text['code5'];
          ShowMessages(message);
          break;
      }

    });
  }}}}}
}
//-------------------- -------------------- --------------------

//validates
function ValidateEmail(email) {
  var bool = false;
  if (email == "") {
  }
  /*else if(ValidateFormatEmail(email)){
    bool = text['code6'];
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
function ValidateNick(nick) {
  var bool = false;
  if (nick != "") {
    bool = true;
  }
  InputValidation('nick', bool);

  return bool;
}
function ValidateNewPassword(password) {
  var bool = false;
  if(password != ""){
    if(password.length > 16 || password.length < 8){
      bool = text['code7'];
    }
    else{
      bool = true;
    }
  }else{
    bool = true;
  }
  InputValidation('new_password', bool);

  if (bool !== true) {
    bool = false;
  }
  return bool;
}
function ValidateConfirmNewPassword(password, confirm_password) {
  var bool = false;
  if(password != ""){
    if (confirm_new_password == "") {
    }
    else if(password != confirm_password) {
      bool = text['code8'];
    }
    else{
      bool = true;
    }
  }else{
    bool = true;
  }
  InputValidation('confirm_new_password', bool);

  if (bool !== true) {
    bool = false;
  }
  return bool;
}
function ValidatePassword(password) {
  var bool = false;
  if (password != "") {
    bool = true;
  }
  InputValidation('password', bool);

  return bool;
}
//-------------------- -------------------- --------------------

//pre_view
const inputID = "new_profile_img";
const srcDefault = document.querySelector("#"+inputID+"_label img").src;
const input = document.getElementById(inputID);
input.addEventListener('change', function () { 
  Preview(inputID, srcDefault); 
  action_img.value = "change";
});

const previewButton = document.querySelector("#"+inputID+"_button");
const check = document.querySelector("#"+inputID+"_check");

previewButton.addEventListener('click', ResetImg);

function ResetImg(){ 
  action_img.value = ""; 
  check.checked = true;
  
  setTimeout(function () {
    previewButton.style.display = "none";
    document.querySelector("#"+inputID+"_label img").src = srcDefault;
  }, 500);

  setTimeout(function () {
      check.checked = false;
  }, 1000);
}

document.getElementById("delete_img").onclick = function () {
  DeleteImg();
}
function DeleteImg(){ 
  input.value = "";
  action_img.value = "delete";
  check.checked = true;
  
  setTimeout(function () {
    previewButton.style.display = "block";
    document.querySelector("#"+inputID+"_label img").src = '../assets/profiles/default.jpg';
  }, 500);

  setTimeout(function () {
      check.checked = false;
  }, 1000);

}
//-------------------- -------------------- --------------------