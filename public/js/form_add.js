const buttonShow = document.getElementById("button_show");
const formAdd = document.getElementById("form_add");
const charForm = document.getElementById("charForm");
var charFormH;

if (!!formAdd) {
  var formH = formAdd.getBoundingClientRect().height;
  if (!!charForm) {
   charFormH = charForm.getBoundingClientRect().height;
  }else{
    charFormH = 0;
  }
  formAdd.style.height = 0;

  window.addEventListener('resize', function () {
    formAdd.style.height = "unset";
    formH = formAdd.getBoundingClientRect().height;
    charFormH = charForm.getBoundingClientRect().height;
    formAdd.style.cssText = "polygon(0 0, 100% 0, 100% 0, 0 0);";
    formAdd.style.height = 0;
    buttonShow.dataset.action = "open";
  });
}

if (!!buttonShow) {
  buttonShow.onkeydown = function(e) { 
    if (e.key == "Tab") {
      if (document.getElementById("form_add").getBoundingClientRect().height < 20) {
        document.querySelectorAll("#form_add button")[1].focus();
      }
    }
  }

  buttonShow.onclick = function(e) { 
    state = buttonShow.dataset.action;
    if (state == "open") {
      let start = Date.now();
      let timer = setInterval(function() {
        let timePassed = Date.now() - start;
        formAdd.style.height = timePassed  + 'px';

        if (timePassed > formH-charFormH) {
          clearInterval(timer)
          formAdd.style.height = 'unset';
        };
  
      }, 20);
      formAdd.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);";
      buttonShow.dataset.action = "close";
    }
    if (state == "close") {
      formAdd.style.cssText = "clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);";
      
      let start = Date.now();
      let timer = setInterval(function() {
        let timePassed = Date.now() - start;
        formAdd.style.height = formH-charFormH - timePassed + 'px';
        if (timePassed > formH-charFormH) {
          clearInterval(timer);
          formAdd.style.height = '0';
        };
      }, 20);
      buttonShow.dataset.action = "open";
    }
  };
}

const selectsFormAdd = document.querySelectorAll("#form_add select");
selectsFormAdd.forEach(element => {
  element.onchange = function () {
    if (element.value == "") {
      element.style.color = "#704c24";
    }else{
      element.style.color = 'white';
    }
  }
});
