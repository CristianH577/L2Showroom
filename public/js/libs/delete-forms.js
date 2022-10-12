export {DeleteForms};

function DeleteForms() {
    var buttonForm = document.querySelectorAll(".emergent_form");
    
    buttonForm.forEach(element => {
        var id = element.dataset.id;
        var action = element.dataset.action;
        var msg = element.dataset.msg;
        var inputName = element.dataset.name;
    
        var newDivForm = document.createElement("div");
            newDivForm.setAttribute("class", "modalForm");
        var newImgForm = document.createElement("img");
            newImgForm.setAttribute("src", "../assets/svg/alert.svg");
        var newPForm = document.createElement("p");
            newPForm.innerText = msg;
    
        var newForm = document.createElement("form");
            newForm.setAttribute("method", "POST");
            newForm.setAttribute("action", action);
        var newInput = document.createElement("input");
            newInput.setAttribute("type", "hidden");
            newInput.setAttribute("name", inputName);
            newInput.setAttribute("value", id);
        var newButtonAccept = document.createElement("button");
            newButtonAccept.setAttribute("class", "button accept");
            newButtonAccept.textContent = "Aceptar";
        var newButtonCancel = document.createElement("button");
            newButtonCancel.setAttribute("class", "button cancel");
            newButtonCancel.setAttribute("type", "button");
            newButtonCancel.textContent = "Cancelar";
    
        newForm.appendChild(newInput);
        newForm.appendChild(newButtonAccept);
        newForm.appendChild(newButtonCancel);
    
        newDivForm.appendChild(newImgForm);
        newDivForm.appendChild(newPForm);
        newDivForm.appendChild(newForm);
    
        element.insertAdjacentElement("afterend", newDivForm);
    });
    
    var modalForm = document.querySelectorAll(".modalForm");
    var modalButtonCancel = document.querySelectorAll(".modalForm form button.cancel");
    
    
    for (let i = 0; i < buttonForm.length; i++) {
        buttonForm[i].onclick = function () {
            modalForm[i].style.display = "flex";
        }
    }
    for (let i = 0; i < modalButtonCancel.length; i++) {
        modalButtonCancel[i].onclick = function () {
            modalForm[i].style.display = "none";
        }
    }
}