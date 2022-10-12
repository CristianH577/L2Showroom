export {ChangeStyleButton, Dark, Light};

function ChangeStyleButton() {
    var on = document.getElementById("on");
    var off = document.getElementById("off");
    on.id = "off";
    off.id = "on";
}

function Dark() {
    var rootStyles = document.documentElement.style;
    document.cookie = 'st=; max-age=0';

    rootStyles.setProperty('--background', 'black');
    rootStyles.setProperty('--backgroundNAV', 'rbg(0,0,0,0.8)');
    rootStyles.setProperty('--backgroundIMG', 'url("../../assets/images/main_background_dark.jpg")');

    rootStyles.setProperty('--fontColor', 'white');
    rootStyles.setProperty('--fillColor', 'white');

    rootStyles.setProperty('--color1', '#ffc45f');
    rootStyles.setProperty('--color2', '#d8cbb5');
    rootStyles.setProperty('--colorSelect', '#ffc45f');
}

function Light(b) {
    var rootStyles = document.documentElement.style;
    if (!b) {
        document.cookie = 'st=light';
    }

    rootStyles.setProperty('--background', '#d8cbb5');
    rootStyles.setProperty('--backgroundNAV', 'rgb(216, 203, 181,0.8)');
    rootStyles.setProperty('--backgroundIMG', 'url("../../assets/images/main_background_light.jpg")');

    rootStyles.setProperty('--fontColor', 'black');
    rootStyles.setProperty('--fillColor', 'black');
    
    rootStyles.setProperty('--color1', '#ffa200');
    rootStyles.setProperty('--color2', 'black');
    rootStyles.setProperty('--colorSelect', '#370c0c');
}