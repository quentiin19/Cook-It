const request = new XMLHttpRequest;

const search_bar = document.getElementById("search_bar_ajax");
const search_button = document.getElementById("search_button_ajax");
const result_ajax = document.getElementById("result_ajax");
const recettes = document.getElementById("recettes");

//récupération des coordonnées de la barre de recherche
//var coor_sb = search_bar.getBoundingClientRect();

//écouteurs
search_bar.addEventListener("input", onclickajax);


console.log("testetestsetsts");

function clean_str_ajax(str){
    let new_str = [];
    console.log(`uncleaned string : ${str}`);
    let a = "àáâäAÀÁÂÄ";
    let e = "èéêëEÈÉÊË";
    let i = "ìíîïIÌÍÎÏ";
    let o = "òóôöOÒÓÔÖ";
    let u = "ùúûüUÙÚÛÜ";
    let liaison = ['à', 'au', 'aux', 'le', 'la' , 'les', 'pour', 'dans', 'avec', 'sans'];

    //on supprime les mots de liaisons qui ne sont pas utiliser dans la recherche en bdd
    /*
    for (let i = 0; i < liaison.length; i++) {
        let position = string.indexOf(liaison[i]);
        if (position != -1){
            string.slice(position, liaison[i].length);
        }
    }
    */

    //on remplace les lettres qui pourrait fausser notre rechercher en bdd
    for (let k = 0; k < str.length; k++) {
        console.log("boucle numéro 1")
        for (let j = 0; j < a.length; j++) {
            if (str[k] == a[j]){
                new_str += 'a';
                break;
            }else if(str[k] == e[j]){
                new_str += 'e';
                break;
            }else if(str[k] == i[j]){
                new_str += 'i';
                break;
            }else if(str[k] == o[j]){
                new_str += 'o';
                break;
            }else if(str[k] == u[j]){
                new_str += 'u';
                break;
            }else if(str[k] == ' '){
                new_str += '-';
                break;
            }else{
                new_str += str[k]
                break;
            }
        }
    }

    console.log(`cleaned string : ${new_str}`);
    return new_str;
}


function onclickajax() {
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str_ajax(search_bar.value);


    //envoi de la requete
    request.addEventListener("load", display_results);
    request.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=1`);
    request.send();

    console.log("requete envoyée");

}

function display_results() {
    recettes.innerHTML = "";
    console.log(JSON.parse(request.response));

    let recipes = JSON.parse(request.response);
    console.log(recipes);

    for (const recipe of recipes) {
        const main_div = document.createElement("div");
        main_div.setAttribute("class", "col-lg-3 col-md-4 col-sm-1 py-3");

        const second_div = document.createElement("div");
        second_div.setAttribute("class", "card cardh mb-4 shadow-sm bg-color py-3 px-3 arrondie");
        second_div.setAttribute("style", "width: 35rem");


        const a = document.createElement("a");
        a.setAttribute("href", `https://cookit.ovh/recette.php?id=${recipe['ID']}`);

        const img = document.createElement("img");
        img.setAttribute("src", `${recipe['PICTURE_PATH']}`);
        img.setAttribute("height", "100px");
        img.setAttribute("width", "100%");

        const third_div = document.createElement("div");
        third_div.setAttribute("class", "card-body arrondie");

        const fourth_div = document.createElement("div");
        fourth_div.setAttribute("class", "row");

        const fifth_div = document.createElement("div");
        fifth_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");

        const sixth_div = document.createElement("div");
        sixth_div.setAttribute("class", "col-lg-6 col-md-6 col-sm-6 px-2 py-2 border");
        sixth_div.setAttribute("height", "100px");

        const title = document.createElement("h4");
        title.innerText = `${recipe['TITLE']}`;

        const creator = document.createElement("p");
        creator.innerText = `Créé par ${recipe['PSEUDO']}`;

        const seventh_div = document.createElement("div");
        seventh_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");




        
        sixth_div.appendChild(title);
        sixth_div.appendChild(creator);

        fourth_div.appendChild(fifth_div);
        fourth_div.appendChild(sixth_div);
        fourth_div.appendChild(seventh_div);

        third_div.appendChild(fourth_div);

        a.appendChild(img);
        a.appendChild(third_div);

        second_div.appendChild(a);

        main_div.appendChild(second_div);

        recettes.appendChild(main_div);

    }
}




/*
détection
*/