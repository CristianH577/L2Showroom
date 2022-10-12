export{VerifyNumber};

function VerifyNumber() {
    var inputsVerifyNumber = document.querySelectorAll(".verifyNumber");
    
    inputsVerifyNumber.forEach(element => {
        element.onkeypress = function (e) {
            if (e.keyCode < 44 || e.keyCode > 57) e.returnValue = false;
            if (document.getElementById(element.id).value[0] == undefined && e.keyCode == 48) e.returnValue = false;
        }
        element.onkeyup = function () {
            var input = document.getElementById(element.id);
            var num = input.value;
            
            num = num.replace(/,/g, "");
            num = num.replace(/-/g, "");
            num = num.replace(/\//g, "");
            num = num.replace(/\./g, "");
            
            var numF = Intl.NumberFormat('es-MX').format(num);
            
            if (num != "") {
                input.value = numF;
            }
        
            if (num < 10000) {
                input.style.color = "white";
            } else
            if (num < 100000) {
                input.style.color = "aqua";
            } else
            if (num < 1000000) {
                input.style.color = "blueviolet";
            } else
            if (num < 10000000) {
                input.style.color = "yellow";
            } else
            if (num < 100000000) {
                input.style.color = "green";
            } else
            if (num < 1000000000) {
                input.style.color = "orange";
            } else
            if (num < 10000000000) {
                input.style.color = "blue";
            } else
            if (num < 100000000000) {
                input.style.color = "red";
            } else
            if (num < 1000000000000) {
                input.style.color = "darkmagenta";
            }
        }
        element.onchange = function () {
            var input = document.getElementById(element.id);
            if (input.value == 0) {
                input.value = "";
            }
        }
    });
}