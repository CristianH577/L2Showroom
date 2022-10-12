export {PageMark};

function PageMark() {
    var pathname = window.location.pathname;
    var locations = pathname.split('/');
    var mark = "";

    switch (locations[3]) {
        case '':
            mark = "home";
            break;

        case 'main':
            mark = "home";
            break;

        case 'market':
            mark = "market";
            break;

        case 'items':
            mark = "market";
            break;

        case 'stores':
            mark = "stores";
            break;

        case 'contact':
            mark = "contact";
            break;

        case 'signup':
            mark = "signup";
            break;

        case 'login':
            mark = "login";
            break;

        case 'dashboard':
            mark = "dashboard";
            break;

        case 'mystore':
            mark = "mystore";
            break;

        case 'admin':
            mark = "admin";
            break;

        case 'users':
            mark = "users";
            break;
        
        default:
            mark = "nopage";
            break;
    }

    if (mark != "nopage") {
        document.querySelector("#nav_" + mark + " a").style.cssText = "color: var(--color1);";
        if (!!document.querySelector("#nav_" + mark + " svg")) {
            document.querySelector("#nav_" + mark + " svg").style.cssText = "fill: var(--color1);";
        }
    }
}
