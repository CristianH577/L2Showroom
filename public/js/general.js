//import
import { DeleteForms } from './libs/delete-forms.js';
import { ChangeLenguage } from './libs/change-lenguage.js';
import { ChangeStyleButton, Dark, Light } from './libs/page-style.js';
import { EmergentMessage } from './libs/show-messages.js';
import { OrdersDecoration } from './libs/orders-decoration.js';
import { PageMark } from './libs/page-mark.js';
//-------------------- -------------------- --------------------

//vars
var rootStyles = document.documentElement.style;
const pageStyleButton = document.getElementById("page_style_button")
const fontSize = document.getElementById("font_size");
const selectLenguage = document.getElementById('lenguage');
//-------------------- -------------------- --------------------

//events
selectLenguage.value = url['lenguage'];

if (!!document.getElementById("error")) {
  EmergentMessage("error");
}
if (!!document.getElementById("success")) {
  EmergentMessage("success");
}

window.onload = function () {
    OrdersDecoration();
    PageMark();
    DeleteForms();
}

pageStyleButton.onclick = function () {
    ChangeStyleButton();
    if (pageStyleButton.className == "dark") {
        Light(false);
        pageStyleButton.classList.remove("dark");
        pageStyleButton.classList.add("light");
    }
    else if (pageStyleButton.className == "light"){
        Dark();
        pageStyleButton.classList.remove("light");
        pageStyleButton.classList.add("dark");
    }
}
fontSize.onchange = function () {
    var size = fontSize.value;
    if (size == '18') {
        document.cookie = 'fz=; max-age=0';
    }else{
        document.cookie = 'fz='+size;
    }
    rootStyles.setProperty('--fontSize1', size+'px');
}
selectLenguage.onchange = function() {
    ChangeLenguage(selectLenguage.value);
}
//-------------------- -------------------- --------------------

//cookies
var cookiesString = document.cookie.split(';');
var cookie = [], cookieString;
for (let i = 0; i < cookiesString.length; i++) {
    cookieString = cookiesString[i].split('=');
    cookie[cookieString[0].trim()] = cookieString[1]
}
if (!!cookie['st']) {
    if (cookie['st'] == 'light') {
        ChangeStyleButton();
        Light(true);
    }
}

if (!!cookie['fz']) {
    fontSize.value = cookie['fz'];
    rootStyles.setProperty('--fontSize1', cookie['fz']+'px');
}
//-------------------- -------------------- --------------------

//menu movil
window.addEventListener('scroll', function () {
    HiddenSession();
});
function HiddenSession() {
    var bodyH = document.getElementsByTagName("body")[0].getBoundingClientRect().height;
    var windowW = window.innerWidth;
    var submenumovil = document.querySelector(".nav_menu");

    if (window.scrollY < 50) {
        bodyH = 100 - (window.scrollY);
    }else{
        bodyH = 50;
    }

    if (windowW <= 720) {
        submenumovil.style.cssText = "top: "+bodyH+"px;";
    }
}

//submenu
var buttonSubmenu = document.querySelectorAll(".svg-movil");

buttonSubmenu.forEach(element => {
    element.onclick = function () {
        var id = element.parentNode.parentNode.id;
        var submenu = document.querySelector("#submenu_"+id);
        if (submenu.style.display == "block") {
            submenu.style.display = "none";
        }else{
            submenu.style.display = "block";
        }
    }
});
//-------------------- -------------------- --------------------

//move up
const moveup = document.querySelector("#moveup");

moveup.addEventListener('click', function () {
	window.scroll(0,0);
});

window.addEventListener('scroll', function () {
	if (window.scrollY > 0) {
		moveup.style.visibility = "unset";
	}else{
		moveup.style.visibility = "hidden";
	}
});
//-------------------- -------------------- --------------------

//nav tab
var navItem = document.querySelectorAll(".nav_item");

navItem.forEach(element => {
    element.onkeydown = function (e) {
        if (e.key == "Tab") {
            var li = element.parentNode.parentNode;
            var id = li.id;
            if (!!id != "") {
                var subMenu = document.querySelector("#"+id+" .submenu");
                subMenu.style.overflow = "unset";
                subMenu.style.height = "50px";
    
                subMenu.onkeydown = function (e) {
                    subMenu.style.overflow = "hidden";
                    subMenu.style.height = "0";
                }
            }
        }
    }
});
document.getElementById("button_config").onkeydown = function (e) {
    if (e.key == "Enter") {
        document.getElementById("nav_config").style.cssText = "display: flex !important;";
    }
}
selectLenguage.onkeydown = function (e) {
    if (e.key == "Tab") {
        document.getElementById("nav_config").style.cssText = "display: none;";
    }
}
//-------------------- -------------------- --------------------