class Image{
    constructor(i, img){
        this.index = i;
        this.image = img
    }
}


const height_canva = 200;
const width_canva = 200;


let skins = [];
let current_skin = 0;
const total_skins = 4;

let eyes = [];
let current_eye = 0;
const total_eyes = 3;


const canva = document.getElementById("avatar-canva");



function setup() {
    //setup des images des couleurs de peau
    for (let i = 0; i < total_skins; i++) {
        let img = `img/skin${i}.png`;
        skins[i] = new Image(i, img);
    }

    //setup des images des yeux
    for (let i = 0; i < total_eyes; i++) {
        let img = `img/eye${i}.png`;
        eyes[i] = new Image(i, img);
    }
}


function draw_avatar() {
    //reset de la canva
    canva.innerHTML = "";

    //skin drawing
    let img_skin = document.createElement("img");
    img_skin.setAttribute("height", `${height_canva}px`);
    img_skin.setAttribute("width", `${width_canva}px`);
    img_skin.setAttribute("src", skins[current_skin].image);

    canva.appendChild(img_skin);
    console.log("skin drawn");


    //eye drawing
    let img_eye = document.createElement("img");
    img_eye.setAttribute("height", `${height_canva}px`);
    img_eye.setAttribute("width", `${width_canva}px`);
    img_eye.setAttribute("src", skins[current_skin].image);

    canva.appendChild(img_eye);
}


function change_part($action) {
    console.log($action);
    switch ($action) {
        case 'prev-skin':
            if (current_skin == 0) {
                current_skin = total_skins - 1;
            }else{
                current_skin = current_skin - 1;
            }
            console.log(current_skin);
            break;
        
        case 'next-skin':
            if (current_skin == total_skins - 1) {
                current_skin = 0;
            }else{
                current_skin = current_skin + 1;
            }
            console.log(current_skin);
            break;

        case 'prev-eye':
            if (current_eye == 0) {
                current_eye = total_eyes - 1;
            }else{
                current_eye = current_eye - 1;
            }
            console.log(current_eye);
            break;

        case 'next-eye':
            if (current_eye == total_eyes - 1) {
                current_eye = 0;
            }else{
                current_eye = current_eye + 1;
            }
            console.log(current_eye);
            break;


        default:
            break;
    }
    
    draw_avatar();
}

function test($texte) {
    console.log($texte);
}

setup();
//draw_avatar();