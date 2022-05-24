class Tile{
    constructor(i, img){
        this.index = i;
        this.image = img
    }
}

let tiles = [];

let moved_tiles = [];

var buttons = [];


const captcha = document.getElementById("puzzle");

const height_tile = "100px";
const width_tile = "100px";





console.log("come le raciste");


//mise en place des tuiles (objet Tile) dans le tableau tiles
function setup_tiles() {
    for (let i = 0; i < 9; i++) {
        let img = `ressources/images/captcha/${i}.png`;
        let tile = new Tile(i, img);

        tiles[i] = tile;
        moved_tiles[i] = i;
    }   
}

//mélange du puzzle
function shuffle() {
    for (let i = 0; i < 10; i++) {
        let temp = Math.floor(Math.random() * 9);


        let j = (temp % 3);
        let k = (temp - j) / 3;  

        move(j, k);
    }
}

//fonction pour faire bouger une tuile vers l'endroit vide lorsque l'utilisateur clique dessus
function move(i, j) {
    let blank_index = find_blank();
    let blank_rows = (blank_index % 3);
    let blank_cols = (blank_index - blank_rows) / 3;


    //si les deux tuiles sont collées, on peut échanger leurs places
    if(isNeighbor(i, j, blank_rows, blank_cols)){
        swap(blank_index, (i + j * 3), moved_tiles);

    }
}

function find_blank() {
    for (let i = 0; i < moved_tiles.length; i++) {
        //Si la tuile à pour id 8, c'est la tuile "vide". On retourne donc son index
        if (moved_tiles[i] == 8) {
            return i;
        }
    }
}

function isNeighbor(i, j, x, y) {
    //si les tuiles ne sont pas sur la même colonne et la même ligne
    if (i != x && j != y) {
        return false;
    }

    //si les tuiles sont côte à côte
    if ((i - x == 1) || (x - i == 1) || (j - y == 1) || (y - j == 1)) {
        return true;
    }
    return false;
}

//permet d'échanger l'index de deux tuiles
function swap(i, j, arr) {
    let temp = arr[i];
    arr[i] = arr[j];
    arr[j] = temp;
}

//permet d'afficher la nouvelle version du puzzle après un mouvement de l'utilisateur
function draw() {
    for (let i = 0; i < moved_tiles.length; i++) {
        let temp = moved_tiles[i];

        //IMAGE
        let img = document.createElement("img");

        img.setAttribute("src", tiles[temp].image);
        img.setAttribute("height", `${height_tile}`);
        img.setAttribute("width", `${width_tile}`);

        //BOUTON
        let button = document.createElement("button");
        button.setAttribute("class", "captcha-tile");
        button.setAttribute("id", `${moved_tiles[i]}`);
        button.setAttribute("onclick", `pressed(${i})`);


        button.appendChild(img);



        //après 3 tuiles, nous revenons à la ligne pour former un carré
        if (i != 0 && i % 3 == 0) {
            let br = document.createElement("br");
            captcha.appendChild(br);
        }

        captcha.appendChild(button);
    }
    let br = document.createElement("br");
    captcha.appendChild(br);    

    let retry = document.createElement("button");
    retry.setAttribute("onclick", "shuffle()");
    retry.innerHTML = "recommencer";

    captcha.appendChild(retry);
}

function verify() {
    for (let i = 0; i < (moved_tiles.length - 1); i++) {
        if (moved_tiles[i] > moved_tiles[i + 1]) {
            return false;
        }
    }
    return true;
}

//fonction appelée dès qu'un bouton est pressé
function pressed(index) {
    captcha.innerHTML = "";

    //calcul des coordonnées du bouton pressé
    let i = (index % 3);
    let j = (index - i) / 3;

    move(i, j);
    draw();

    if (verify()) {
        console.log("captcha validé");
    }
}



//mise en place des tuiles du captcha ainsi que des listner
function setup_captcha() {

    setup_tiles();
    shuffle();
    draw();
}



setup_captcha();





/*

TO DO :

fonction verify()
ajout du bouton de suite de la page si verify == true


*/