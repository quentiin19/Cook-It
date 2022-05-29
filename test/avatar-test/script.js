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

let mouths = [];
let current_mouth = 0;
const total_mouths = 3;


const canva = document.getElementById("avatar-canva");
const download_button = document.getElementById("avatar-download-button");




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

    //setup des images des bouches
    for (let i = 0; i < total_mouths; i++) {
        let img = `img/mouth${i}.png`;
        mouths[i] = new Image(i, img);
    }

    draw_avatar();
}


function draw_avatar() {
    //reset de la canva
    canva.innerHTML = "";

    //skin drawing
    let img_skin = document.createElement("img");
    img_skin.setAttribute("height", `${height_canva}px`);
    img_skin.setAttribute("width", `${width_canva}px`);
    img_skin.setAttribute("class", "avatar-skin");
    img_skin.setAttribute("src", skins[current_skin].image);

    canva.appendChild(img_skin);


    //eye drawing
    let img_eye = document.createElement("img");
    img_eye.setAttribute("height", `${height_canva}px`);
    img_eye.setAttribute("width", `${width_canva}px`);
    img_eye.setAttribute("class", "avatar-part");
    img_eye.setAttribute("src", eyes[current_eye].image);

    canva.appendChild(img_eye);


    //mouth drawing
    let img_mouth = document.createElement("img");
    img_mouth.setAttribute("height", `${height_canva}px`);
    img_mouth.setAttribute("width", `${width_canva}px`);
    img_mouth.setAttribute("class", "avatar-part");
    img_mouth.setAttribute("src", mouths[current_mouth].image);

    canva.appendChild(img_mouth);


    //configuration du lien pour le téléchargement
    let link = `51.255.172.36/test/avatar-test/avatar_creation.php?skin=${current_skin}&eye=${current_eye}&mouth=${current_mouth}`;
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

        case 'prev-mouth':
            if (current_mouth == 0) {
                current_mouth = total_mouths - 1;
            }else{
                current_mouth = current_mouth - 1;
            }
            console.log(current_mouth);
            break;

        case 'next-mouth':
            if (current_mouth == total_mouths - 1) {
                current_mouth = 0;
            }else{
                current_mouth = current_mouth + 1;
            }
            console.log(current_mouth);
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