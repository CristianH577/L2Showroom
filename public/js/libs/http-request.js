export {HttpRequest};

function HttpRequest(action, callback){
    const http = new XMLHttpRequest();
    http.open("GET", url['constantURL']+action);
    http.send();

    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            callback.apply(http);
        }
    }
}