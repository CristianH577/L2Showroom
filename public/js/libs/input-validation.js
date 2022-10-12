export {InputValidation, InputMessage};
import { input } from '../lenguage/lenguage.js';
var text = input[url['lenguage']];

function InputValidation(id, message) {
    var input = document.getElementById(id);

    const borderY = "1px solid #704c24"
    const borderN = "groove red 1px";

    if (input.type == "file") {
        input =  document.getElementById(id+"_img");
    }

    if (message === true) {
        input.style.border = borderY;
    }
    else if(message === false){
        input.style.border = borderN;
    }
    else{
        input.style.border = borderN;
    }
    InputMessage(id, message);
}

function InputMessage(id, message) {
    var input = document.querySelector("#"+id);
    var inputW = input.getBoundingClientRect().width;
    var li = input.parentNode;
    var div = document.querySelector("#"+id+"-message");
    var p = document.querySelector("#"+id+"-message p");

    if (id.includes("password")) {
        li = input.parentNode.parentNode;
    }else{
        li = input.parentNode;
    }

    if (message === true) {
        message = "";
    }
    else if(message === false){
        message = text['message'];
    }

    if (message == "") {
        if (!!div) {
            div.remove();
        }
    }else{
        if (!!div) {
            p.textContent = message;
        }else{
            var div = document.createElement("div");
                div.setAttribute("id", ""+id+"-message");
                div.setAttribute("class", "center");
            var p = document.createElement("p");
                p.setAttribute("class", "input-message");

            if (inputW > 32) {
                p.style.cssText = "width: "+inputW+"px;";
            }

            div.appendChild(p);
            li.insertAdjacentElement("beforeend", div);
            p.textContent = message;
        }
    }
}