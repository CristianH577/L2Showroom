export { Preview };

import { InputMessage } from './input-validation.js';
import { view } from '../lenguage/lenguage.js';
var text = view[url['lenguage']];

function Preview(inputID, srcDefault) {
    var input = document.getElementById(inputID);
    var path = input.value;
    var nav = window.URL || window.webkitURL;
    var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
    var labelIMG = document.querySelector("#"+inputID+"_label img");
    var check = document.querySelector("#"+inputID+"_check");
    var button = document.querySelector("#"+inputID+"_button");
    InputMessage(inputID+'_label', '');

    if(path != ''){
        if (!allowedExtensions.exec(path)) {
            input.value = "";
            
            InputMessage(inputID+'_label', text['message']);

            if(labelIMG){
                check.checked = true;
                setTimeout(function () {
                    button.style.display = "none";
                    labelIMG.src = srcDefault;
                }, 500);
        
                setTimeout(function () {
                    check.checked = false;
                }, 1000);
            }
        } else {
            check.checked = true;
            var object_url = nav.createObjectURL(input.files[0]);

            setTimeout(function () {
                labelIMG.src = object_url;
                button.style.display = "block";
            }, 500);

            setTimeout(function () {
                check.checked = false;
            }, 1000);
        }
    } else{
        check.checked = true;
        setTimeout(function () {
            button.style.display = "none";
            labelIMG.src = srcDefault;
        }, 500);

        setTimeout(function () {
            check.checked = false;
        }, 1000);
    }

    button.addEventListener('click', function () { 
        input.value = "";
        check.checked = true;

        setTimeout(function () {
            button.style.display = "none";
            labelIMG.src = srcDefault;
        }, 500);

        setTimeout(function () {
            check.checked = false;
        }, 1000);
    });

}