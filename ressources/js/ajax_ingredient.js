//requetes
const request_ajax = new XMLHttpRequest;

//elements du dom
const search_bar_ingredients = document.getElementById("search-bar-ingredient");
const ingredients = document.getElementById("ingredients");

//variables
let keyword = "";


//écouteur
search_bar_ingredients.addEventListener("input", onclickingredients);





function clean_str_ajax(str){
    let new_str = [];
    console.log(`uncleaned string : ${str}`);
    let liaison = ['à', 'au', 'aux', 'le', 'la' , 'les', 'pour', 'dans', 'avec', 'sans'];

    //on remplace les lettres qui pourrait fausser notre rechercher en bdd
    for (let k = 0; k < str.length; k++) {
        if(!(k == (str.length - 1) && str[k] == ' ')){
            if(str[k] == ' '){
                new_str += '-';
            }else{
                new_str += str[k]
            }
        }
    }

    console.log(`cleaned string : ${new_str}`);
    return new_str;
}

function onclickingredients() {
    //récupération de la valeur dans la barre de recherche
    keyword = clean_str_ajax(search_bar_ingredients.value);

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_ingredient);
    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keyword}&action=2`);
    request_ajax.send();


}


function display_results_ingredient(){
    if(search_bar_ingredients.value == "sananes"){
        //hide tous les éléments
        for (const element of ingredients.childNodes) {
            element.hidden = true;

            if(element.id == 38){
                element.hidden = false;
            }
        }
    }
    if(keyword == ""){
        //hide tous les éléments
        for (const element of ingredients.childNodes) {
            element.hidden = false;

            if(element.id == 38){
                element.hidden = true;
            }
        }
    }else{
        let ingredients_resp = JSON.parse(request_ajax.response);
        console.log(ingredients_resp);
    
    
        //hide tous les éléments
        for (const element of ingredients.childNodes) {
            element.hidden = true;
        }
    
        //afficher tous les éléments présents dans ingredients_resp
        for (const element of ingredients.childNodes) {
            for (const ingredient of ingredients_resp) {
                if(element.id == ingredient['ID']){
                    element.hidden = false;
                    
                    break;
                }
            }
            if(element.id == 38){
                element.hidden = true;
            }
        }
    }
}


