export {ShowOrdersImgs};

function ShowOrdersImgs() {
    var charRows = document.querySelectorAll(".char");
    if (!!charRows) {
        charRows.forEach(element => {
            var id = element.dataset.id;
            var imgs = document.querySelector("#imgs-"+id);
            if (!!imgs) {
                element.firstChild.style.cssText = "border-bottom: 1px solid goldenrod;";
                element.onclick = function () {
                    if (imgs.style.display == "table-row") {
                        imgs.style.display = "none";
                    }else{
                        imgs.style.display = "table-row";
                    }
                }
            }
        });
    }
}