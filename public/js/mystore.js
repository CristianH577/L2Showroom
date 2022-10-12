//import
import { mystore } from './lenguage/lenguage.js';
var text = mystore[url['lenguage']];

import { HttpRequest } from './libs/http-request.js';
import { InputValidation } from './libs/input-validation.js';
import { Preview } from './libs/preview.js';
import { ShowMessages } from './libs/show-messages.js';
import { ShowOrdersImgs } from './libs/show-orders-img.js';
import { VerifyNumber } from './libs/verify-number.js';
import { zoom } from './libs/zoom-img.js';
//-------------------- -------------------- --------------------

//vars
const formAddElements = document.querySelectorAll("#form_add input, #form_add select");
const radios = document.querySelectorAll("#form_add input[type='radio']");
const userID = document.getElementById("id_user").value;

const itemForm = document.getElementById("itemForm");
const charForm = document.getElementById("charForm");

const filesInput = document.querySelectorAll("#form_add input[type='file']");
const elementsID = [], srcDefault = [];
for (let i = 0; i < filesInput.length; i++) {
    elementsID[i] = filesInput[i].id;
    srcDefault[i] = document.querySelector("#"+elementsID[i]+"_label img").src;
}
//-------------------- -------------------- --------------------

//events
charForm.style.display = "none";

radios.forEach(element => {
    element.onclick = function () {
        ResetFormAdd();
        if (element.value == "item") {
            itemForm.style.display = "flex";
            charForm.style.display = "none";
        }
        if (element.value == "char") {
            itemForm.style.display = "none";
            charForm.style.display = "flex";
        }
    }
});

ShowOrdersImgs();
VerifyNumber();
zoom();

for (let i = 0; i < filesInput.length; i++) {
    filesInput[i].onchange = function () {
        Preview(elementsID[i], srcDefault[i]);
    }
}
//-------------------- -------------------- --------------------

//reset
document.getElementById("resetFormAdd").onclick = function () {
    ResetFormAdd();
}
function ResetFormAdd() {
  formAddElements.forEach(element => {
    var t = element.type;
      if (t != "radio" && t != "checkbox") {
        element.value = "";
        if (t != "file") {
            InputValidation(element.id, true);
        }
        if (t == "select-one") {
            element.style.color = "#704c24";
        }
      }
  });

  for (let i = 0; i < filesInput.length; i++) {
    Preview(elementsID[i], srcDefault[i]);
  }
  
  Search("");
  SearchImg("");
  ShowMessages("");
}
//-------------------- -------------------- --------------------

//addSearch
const addSearch = document.querySelector("#add_search");
const addDatalist = document.querySelector("#add_datalist");
addSearch.onkeypress = function() { Search(addSearch.value); }
addSearch.onchange = function() { SearchImg(addSearch.value); }
//-------------------- -------------------- --------------------


//validate add form
formAddElements.forEach(element => {
    element.addEventListener('blur', function () {
        if (element.type != "radio") {
            element.value = element.value.trim();
            if (element.value == "") {
                InputValidation(element.id, false);
            }else{
                InputValidation(element.id, true);
            }
        }
    });
});
//-------------------- -------------------- --------------------

//validate add item
const itemID = document.getElementById("id_item");
const quantity = document.getElementById("quantity");
const itemSearch = document.getElementById("add_search");

itemSearch.onblur = function() { 
    if(itemSearch.value != ""){
        ValidateItemID(itemSearch.value);
    }
}

function ValidateItemID(name_item) {
    HttpRequest("mystore/searchID?name=" + name_item , function(){
        var answerSearchID =  this.responseText.trim();
        var message;

        if (answerSearchID == "error-form") {
            message = text['code1'];
            ShowMessages(message);
        }
        else if (answerSearchID != "false" && !isNaN(answerSearchID)) {
            itemID.value = answerSearchID;
            InputValidation('add_search', true);
        }
        else{
            itemID.value = "";
            message = text['code2'];
            InputValidation('add_search', message);
        }

    });

};
//-------------------- -------------------- --------------------

//validate add char
const race = document.getElementById("race");
const occupation = document.getElementById("occupation");
const mystic = document.getElementById("mystic");
const level = document.getElementById("level");
const clase = document.getElementById("class");

race.onblur = function() {
    if (race.value == "Dwarf" || race.value == "Kamael") {
        mystic.style.display = "none";
        occupation.value = "Fighter";
    }else{
        mystic.style.display = "block";
    }
    ShowOptgroup();
}
occupation.onblur = function() { 
    ShowOptgroup();
}
level.onblur = function() {
    var bool = false;
    if (level.value != "") {

        if (level.value < 76 || level.value > 125 || isNaN(level.value)) {
            bool = text['code3'];
        }
        else{
            bool = true;
        }
    }
    InputValidation("level", bool);
}

function ShowOptgroup() {
    document.getElementById("class").value = "";
    var optgroups = document.querySelectorAll("#class optgroup");
    var optgroupID = race.value+occupation.value;

    for (let i = 0; i < optgroups.length; i++) {
        if (optgroups[i].id == optgroupID) {
            optgroups[i].style.display = "block";
        }else{
            optgroups[i].style.display = "none";
        }
    }
    
}
//-------------------- -------------------- --------------------

//send form
const wt = document.getElementById("wt");
const price = document.getElementById("price");

document.getElementById("send_order").onclick = function () {
    Validate();
}
function Validate() {
    var e=0;
    if (wt.value == "") {
        InputValidation("wt", "");
        e++;
    }
    if (price.value == "") {
        InputValidation("price", "");
        e++;
    }

    if (radios[0].checked) {
        SendItem(e);
    }
    else if (radios[1].checked) {
        SendChar(e);
    }

}

function SendItem(e) {
    const formSendElements = document.querySelectorAll("#form_add #itemForm input, #form_add #itemForm select");

    formSendElements.forEach(element => {
        if (element.value == "") {
            InputValidation(element.id, "");
            e++;
        }
    });

    if (e == 0) {
        HttpRequest("mystore/validateNewOrderItem?user=" + userID + "&item=" + itemID.value, function(){

        var answerValidateOrder = this.responseText.trim();
        var message;

        switch (answerValidateOrder) {
            case "false":
                formAdd.submit();
                break;

            case "true":
                message = text['code4'];
                InputValidation('add_search', message);
                break;

            case "error-form":
                message = text['code1'];
                ShowMessages(message);
                break;
        
            default:
                message = text['code5'];
                ShowMessages(message);
                break;
        }

        });
    }
}

function SendChar(e) {
    const formSendElements = document.querySelectorAll("#form_add #charForm input[type='text'], #form_add #charForm select");

    formSendElements.forEach(element => {
        var bool = false;
        if (element.value == "") {
            bool = "";
            e++;
        }else{
            bool = true;
        }
        InputValidation(element.id, bool);
    });

    if (e == 0) {
        HttpRequest("mystore/validateNewOrderChar?user=" + userID + "&data=" + race.value + "_" + occupation.value + "_" + clase.value , function(){

        var answerValidateOrderChar = this.responseText.trim();
        var message;

        switch (answerValidateOrderChar) {
            case "false":
                formAdd.submit();
                break;

            case "true":
                message = text['code6'];
                InputValidation('race', message);
                InputValidation('occupation', message);
                InputValidation('class', message);
                break;

            case "error-form":
                message = text['code1'];
                ShowMessages(message);
                break;
        
            default:
                message = text['code5'];
                ShowMessages(message);
                break;
        }

        });
    }
    
}
//-------------------- -------------------- --------------------

//search item to add
function Search(nameItem) {
    addDatalist.innerHTML = "";
  
    HttpRequest("mystore/searchItemName?name=" + nameItem , function(){

        var answerSearchItem =  this.responseText.trim();
        var message;

        switch (answerSearchItem) {
            case "false":
                //message = text['code5'];
                //ShowMessages(message);
                break;
            case "error-form":
                message = text['code1'];
                ShowMessages(message);
                break;
        
            default:
                var array = answerSearchItem.split(",");
    
                for (let index = 0; index < array.length; index++) {
                    var option = document.createElement("option");
                    option.value = array[index];
                    addDatalist.appendChild(option);
                }
                break;
        }

    });
  
}
//-------------------- -------------------- --------------------

//item pre view
function SearchImg(nameItem){
    const pre_view_item = document.getElementById("pre_view_item");

    addDatalist.innerHTML = "";
  
    HttpRequest("mystore/searchItemImg?name=" + nameItem , function(){

        var answerSearchImg =  this.responseText.trim();
        var message;
        
        switch (answerSearchImg) {
            case "error-form":
                message = text['code1'];
                ShowMessages(message);
                break;
            case "false":
                pre_view_item.innerHTML = '<img src="../assets/items/default.svg" class="icon">';
                break;
        
            default:
                pre_view_item.innerHTML = '<img src="../assets/items/'+answerSearchImg+'" class="icon">';
                break;
        }
    });
}
//-------------------- -------------------- --------------------

//model
if (!!document.getElementById("random")) {
    document.getElementById("random").onclick = function () {
        Model();
    }
}
function Model() {
    wt.value = "S";
    price.value = 1;
    if (radios[0].checked) {
        quantity.value = 1;
    }
    else if (radios[1].checked) {
        race.value = "Human";
        occupation.value = "Mystic";
        clase.value = "Hierophant";
        level.value = "80";
    }
}
//-------------------- -------------------- --------------------