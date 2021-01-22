// This function will center the element.
function center_form(){
    var element = document.querySelector(".form-center");
    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;
    elementWidth = element.offsetWidth;
    elementHeight = element.offsetHeight;

    var cssString = "";
    cssString += "position: absolute;";
    cssString += "left:" + ((window.innerWidth / 2) - (element.offsetWidth / 2)) + "px;";
    cssString += "top:"  + ((window.innerHeight / 2) - (element.offsetHeight / 2)) + "px;";
    element.style.cssText = cssString;
}