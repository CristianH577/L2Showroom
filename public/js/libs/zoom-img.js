export { zoom };

function zoom(){
    var ampliar = document.querySelectorAll(".zoom");
    for (let i = 0; i < ampliar.length; i++) {
    }

    for (let i = 0; i < ampliar.length; i++) {
        var newDiv = document.createElement("div");
            newDiv.setAttribute("class", "modal");
        var newDivCenter = document.createElement("div");
            newDivCenter.setAttribute("class", "center");
        var newImg = document.createElement("img");
            newImg.setAttribute("class", "modal-content");
        var newSubDiv = document.createElement("div");
            newSubDiv.setAttribute("class", "caption");

        newDivCenter.appendChild(newSubDiv);
        newDivCenter.appendChild(newImg);

        newDiv.appendChild(newDivCenter);

        ampliar[i].appendChild(newDiv);
    }

    var modal = document.querySelectorAll(".modal");
    var img = document.querySelectorAll(".zoom > img");
    var modalImg = document.querySelectorAll(".modal-content");
    var captionText = document.querySelectorAll(".caption");

    for (let i = 0; i < img.length; i++) {
        img[i].onclick = function(){
            modal[i].style.display = "block";
            modalImg[i].src = this.src;
            captionText[i].innerHTML = this.alt;
        }
    }

    for (let i = 0; i < modal.length; i++) {
        modal[i].onclick = function() { 
            modal[i].style.display = "none";
        }
    }
}