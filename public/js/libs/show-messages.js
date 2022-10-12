export {ShowMessages, EmergentMessage};

function ShowMessages(message) {
  const messages = document.querySelector("#messages");
  
  if (message == "") {
    if (!!document.querySelector("#messages #message")) {
      document.querySelector("#messages #message").remove();
    }
  }else{
    if (!!document.querySelector("#messages #message p")) {
      document.querySelector("#messages #message p").innerText = message;
    }else{
      var newDiv = document.createElement("div");
        newDiv.setAttribute("id", "message");
      var newp = document.createElement("p");
        newp.innerText = message;
        
      newDiv.appendChild(newp);
      messages.appendChild(newDiv);
    }
    window.scroll(0,0);

  }
}

function EmergentMessage(id) {
  var messages = document.getElementById("messages");
  var img = document.querySelector("#messages #"+id+" img");
  var message = document.querySelector("#messages #"+id+" p").textContent;

  if (!document.querySelector("#modalMessages")) {
    var newDiv = document.createElement("div");
      newDiv.setAttribute("id", "modalMessages");
    var newDivSub = document.createElement("div");
      newDivSub.setAttribute("id", "submodalMessages");
    var newImg = document.createElement("img");
      newImg.setAttribute("id", "modalMessages-img");
    var newP = document.createElement("p");
      newP.setAttribute("id", "modalMessages-message");
      if (!!document.getElementById("error")) {
        newP.style.color = "red";
      }
      if (!!document.getElementById("success")) {
        newP.style.color = "green";
      }
  
    newDivSub.appendChild(newImg);
    newDivSub.appendChild(newP);
    newDiv.appendChild(newDivSub);
    messages.appendChild(newDiv);
  }
  
  var modalMessages = document.querySelector("#modalMessages");
  var submodalMessages = document.querySelector("#submodalMessages");
  var modalMessagesImg = document.querySelector("#modalMessages-img");
  var modalMessagesP = document.querySelector("#modalMessages-message");

  modalMessagesP.textContent = message;
  modalMessagesImg.src = img.src;
  submodalMessages.setAttribute("class", id);
  modalMessages.style.display = "flex";

  modalMessages.onclick = function() {
    if (message != "") {
      modalMessages.style.display = "none";
    }else{
      
    }
  }
}