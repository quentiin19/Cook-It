const button = document.getElementById("burger-menu-button");
const menu = document.getElementById("burger-menu");

button.addEventListener("click", changeState, false);

function changeState() {

    menu.hidden = menu.hidden ? false : true;
    menu.style.zIndex = menu.hidden ? -1 : 100;

    console.log("le menu à changé d'état");
    
}