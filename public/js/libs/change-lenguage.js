export {ChangeLenguage};

function ChangeLenguage(lenguage) {
    var origin  = window.location.origin;
    var pathname  = window.location.pathname;
    var locations = pathname.split('/')
    
    locations[2] = lenguage;

    var newPathname = "";
    for (let index = 1; index < locations.length; index++) {
        newPathname += "/"+locations[index];
    }
    
    const redirect = origin+newPathname;
    window.location = redirect;
}
