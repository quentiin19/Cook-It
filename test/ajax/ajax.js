const request = new XMLHttpRequest;

const search_bar = document.getElementById("search_bar_ajax");
const search_button = document.getElementById("search_button_ajax");
const result_ajax = document.getElementById("result_ajax");

//récupération des coordonnées de la barre de recherche
var coor_sb = search_bar.getBoundingClientRect();

//écouteurs
search_button.addEventListener("click", onclick, false);


function clean_str(str){
    let new_str = str;
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
        for (let j = 0; j < a.length; j++) {
            if (str[k] == a[j]){
                new_str[k] = 'a';
            }else if(str[k] == e[j]){
                new_str[k] = 'e';
            }else if(str[k] == i[j]){
                new_str[k] = 'i';
            }else if(str[k] == o[j]){
                new_str[k] = 'o';
            }else if(str[k] == u[j]){
                new_str[k] = 'u';
            }else if(str[k] == ' '){
                new_str[k] = '-';
            }else{
                new_str[k] = str[k]
            }
        }
    }
    return string;
}


function onclick() {
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str(search_bar.value);


    //envoi de la requete
    request.addEventListener("load", display_results);
    request.open("GET", `http://51.255.172.36/test/ajax/api.php?keywords=${keywords}`);
    request.send();

    console.log("requete envoyée");

}

function display_results() {
    console.log(request.response);
}