//SLIDER
const slider = document.getElementById('slider-container');
const left = document.querySelector('#slider-left');
const rigth = document.querySelector('#slider-rigth');
var sliderButtons = document.querySelectorAll('#slider-console button');

var b = 0;
var i = 0;

var scrollQuantity = slider.offsetWidth;
window.onresize = function () {
    scrollQuantity = slider.offsetWidth;
}
setInterval(Slide, 5000);

sliderButtons.forEach(function (element, index) {
    element.onclick = function() {
        slider.scrollLeft = index*scrollQuantity;
        b = index*scrollQuantity;
        i = index;
        document.querySelector('.active').className = "";
        element.className = "active";
    };
});

function Slide() {
    if (b > scrollQuantity*(sliderButtons.length-2)) {
        slider.scrollLeft = 0;
        b = 0;
        i = 0;
        if (!!sliderButtons[i]) {
            if (!!document.querySelector('.active')) {
                document.querySelector('.active').className = "";
            }
            sliderButtons[i].className = "active";
        }
    }else{
        slider.scrollLeft += scrollQuantity;
        b += scrollQuantity;
        i++;
        if (!!sliderButtons[i]) {
            if (!!document.querySelector('.active')) {
                document.querySelector('.active').className = "";
            }
            sliderButtons[i].className = "active";
        }
    }
}
//-------------------- -------------------- --------------------