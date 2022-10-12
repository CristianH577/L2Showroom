//import
import { items } from './lenguage/lenguage.js';
var text = items[url['lenguage']];

import { HttpRequest } from './libs/http-request.js';
import { InputValidation } from './libs/input-validation.js';
import { Preview } from './libs/preview.js';
import { ShowMessages } from './libs/show-messages.js';
//-------------------- -------------------- --------------------

//var
const type = document.getElementById('add_type');
const itemName = document.getElementById('add_name');
const inputID = "new_icon";
const srcDefault = document.querySelector("#"+inputID+"_label img").src;
//-------------------- -------------------- --------------------

//events
if (!!document.getElementById("reset_form_add")) {
  document.getElementById("reset_form_add").onclick = function () {
    ResetFormAdd();
  }

  document.getElementById(inputID).addEventListener('change', function () {
    Preview(inputID, srcDefault);
  });
}
//-------------------- -------------------- --------------------

//form reset
function ResetFormAdd() {
  type.style.color = "#704c24";
  InputValidation('add_type', true);
  InputValidation('add_name', true);

  formAdd.reset(); 
  ShowMessages("");

  Preview(inputID, srcDefault);
}
//-------------------- -------------------- --------------------

//validation
if (!!type) {
  type.onblur = function() {
    type.value = type.value.trim();
    ValidateType(type.value);
  }
}
if (!!itemName) {
  itemName.onblur = function() { 
    itemName.value = itemName.value.trim();
    ValidateName(itemName.value);
  }
}

function ValidateType(type) {
  var bool = false;
  if (type != "") {
    bool = true;
  }
  InputValidation('add_type', bool);

  return bool;
}

function ValidateName(name) {
  var bool = false;
  if (name != "") {
    bool = true;
  }
  InputValidation('add_name', bool);

  return bool;
}

if (!!document.getElementById("add_item")) {
  document.getElementById("add_item").onclick = function () {
    Validate();
  }
}
function Validate(){
  if (ValidateType(type.value)) {
  if (ValidateName(itemName.value)) {
    HttpRequest("items/validateNewItem?name=" + itemName.value , function(){

      var answerValidate = this.responseText.trim();
      var message;

      switch (answerValidate) {
        case "false":
          document.form_item.submit();
          break;
        case "true":
          message = text['code1'];
          InputValidation('add_name', message);
          break;
        case "error-form":
          message = text['code2'];
          ShowMessages(message);
          break;
        default:
          message = text['code3'];
          ShowMessages(message);
          break;
      }
    });
  }}

}
//-------------------- -------------------- --------------------