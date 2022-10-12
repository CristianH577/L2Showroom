export {OrdersDecoration, ColorNumber, ColorWT};

function OrdersDecoration() {
    //number color
    var cellsNumber = document.getElementsByClassName('number');
    var i = cellsNumber.length;
    while (--i >= 0){
        ColorNumber(cellsNumber[i]);
    }

    //wt type color
    var cellsWT = document.getElementsByClassName('wt');
    var f = cellsWT.length;
    while (--f >= 0){
        ColorWT(cellsWT[f]);
    }
}

function ColorNumber(cellsNumber) {
    var num = Number(cellsNumber.textContent.replace(/,/g, ""));

    if (num < 10000) {
        //cellsNumber.style.color = "white";
    } else
    if (num < 100000) {
        cellsNumber.style.color = "aqua";
    } else
    if (num < 1000000) {
        cellsNumber.style.color = "deeppink";
    } else
    if (num < 10000000) {
        cellsNumber.style.color = "yellow";
    } else
    if (num < 100000000) {
        cellsNumber.style.color = "green";
    } else
    if (num < 1000000000) {
        cellsNumber.style.color = "orange";
    } else
    if (num < 10000000000) {
        cellsNumber.style.color = "blue";
    } else
    if (num < 100000000000) {
        cellsNumber.style.color = "red";
    } else
    if (num < 1000000000000) {
        cellsNumber.style.color = "darkmagenta";
    } 
    
}

function ColorWT(cellsWT) {
    var wt = cellsWT.textContent.trim();

    if (wt == "S") {
        cellsWT.style.color = "green";
    } else
    if (wt == "B") {
        cellsWT.style.color = "blue";
    } else
    if (wt == "T") {
        cellsWT.style.color = "red";
    } else
    if (wt == "S/T") {
        cellsWT.style.color = "yellow";
    } else
    if (wt == "B/T") {
        cellsWT.style.color = "deeppink";
    }
    
}