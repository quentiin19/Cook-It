//déclarations des variables / constantes
const reference = document.getElementById("reference");
const height_r = "300px";
const width_r = "300px";

const puzzle = document.getElementById("puzzle");
const height_tile = "100px";
const width_tile = "100px";

let tuiles = [
    [0, "0.jpeg"],
    [1, "1.jpeg"],
    [2, "2.jpeg"],
    [3, "3.jpeg"],
    [4, "4.jpeg"],
    [5, "5.jpeg"],
    [6, "6.jpeg"],
    [7, "7.jpeg"],
    [8, "8.jpeg"]
];
let solution = [0, 1, 2, 3, 4, 5, 6, 7, 8];

const path_reference = "./img/image.png";

let i = 0;


//events listener

const bouton_tuiles = document.querySelectorAll(".tuile-captcha");

bouton_tuiles.forEach(bouton_tuile => {
    bouton_tuile.addEventListener(onclick, swap_tiles(i));
    i++;
});




//affichage de la référence à reproduire
let image = document.createElement("img");
image.setAttribute("src", `${path_reference}`);
image.setAttribute("height", `${height_r}`);
image.setAttribute("width", `${width_r}`);
reference.appendChild(image);

//création du tableau des tuiles du captcha
for (let i = 0; i < 9; i++) {
    //création de la tuile
    let tuile = document.createElement("img");

    tuile.setAttribute("src", `./img/${tuiles[i][1]}`);
    tuile.setAttribute("height", `${height_tile}`);
    tuile.setAttribute("width", `${width_tile}`);

    //création du bouton pour faire bouger les tuiles
    let bouton = document.createElement("button");
    bouton.setAttribute("class", "tuile-captcha");

    //on introduit l'image dans le bouton
    bouton.appendChild(tuile);

    if (i % 3 == 0){
        let br = document.createElement("br");
        puzzle.appendChild(br) ;      
    }

    puzzle.appendChild(bouton);
}

function shuffle_tiles(params) {
    
}

function swap_tiles(index){
    //si la tuiles que l'on souhaite bouger est la tuile 'vide', on ne fait rien
    if (index != 8){

        let icols = index
        //on vérifie qu'une des tuiles adjacente est la tuile 'vide' pour bouger
        if(1){

        }
    }
}
