class Image{
    constructor(i, img){
        this.index = i;
        this.image = img
    }
}


const height_canva = 300;
const width_canva = 300;


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
    //skin drawing
    let img = document.createElement("img");
    img.setAttribute("height", `${height_canva}px`);
    img.setAttribute("width", `${width_canva}px`);
    img.setAttribute("src", skins[current_skin]);

    canva.appendChild(img);


    //eye drawing
    img.setAttribute("height", `${height_canva}px`);
    img.setAttribute("width", `${width_canva}px`);
    img.setAttribute("src", skins[current_skin]);

    canva.appendChild(img);
}


function click($action) {
    switch ($action) {
        case 'prev-skin':
            if (current_skin == 0) {
                current_skin = total_skins - 1;
            }else{
                current_skin = current_skin - 1;
            }
            break;
        
        case 'next-skin':
            if (current_skin == total_skins - 1) {
                current_skin = 0;
            }else{
                current_skin = current_skin + 1;
            }
            break;

        case 'prev-eye':
            if (current_eye == 0) {
                current_eye = total_eyes - 1;
            }else{
                current_eye = current_eye - 1;
            }
            break;

        case 'next-eye':
            if (current_eye == total_eyes - 1) {
                current_eye = 0;
            }else{
                current_eye = current_eye + 1;
            }
            break;


        default:
            break;
    }
    
    draw_avatar();
}