const request = new XMLHttpRequest;

const search_bar = document.getElementById("search_bar_ajax");
const search_button = document.getElementById("search_button_ajax");
const result_ajax = document.getElementById("result_ajax");

//récupération des coordonnées de la barre de recherche
var coor_sb = search_bar.getBoundingClientRect();

//écouteurs
search_button.addEventListener("click", onclick, false);


function clean_str(str){
    let string = str;
    console.log(`uncleaned string : ${string}`);
    let a = "àáâäAÀÁÂÄ";
    let e = "èéêëEÈÉÊË";
    let i = "ìíîïIÌÍÎÏ";
    let o = "òóôöOÒÓÔÖ";
    let u = "ùúûüUÙÚÛÜ";
    let liaison = ['à', 'au', 'aux', 'le', 'la' , 'les', 'pour', 'dans', 'avec', 'sans'];

    //on supprime les mots de liaisons qui ne sont pas utiliser dans la recherche en bdd
    for (let i = 0; i < liaison.length; i++) {
        let position = string.indexOf(liaison[i]);
        if (position != -1){
            string.slice(position, liaison[i].length);
        }
    }

    //on remplace les lettres qui pourrait fausser notre rechercher en bdd
    for (let k = 0; k < string.length; k++) {
        for (let j = 0; j < a.length; j++) {
            if (string[k] == a[j]){
                string[k] = 'a';
            }else if(string[k] == e[j]){
                string[k] = 'e';
            }else if(string[k] == i[j]){
                string[k] = 'i';
            }else if(string[k] == o[j]){
                string[k] = 'o';
            }else if(string[k] == u[j]){
                string[k] = 'u';
            }else if(string[k] == ' '){
                string[k] = '-';
            }
        }
    }
    console.log(`cleaned string : ${string}`);
    return string;
}


function onclick() {
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str(search_bar.value);

    

    console.log(keywords);

    //envoi de la requete
    request.addEventListener("load", display_results);
    request.open("GET", `http://51.255.172.36/test/ajax/api.php?keywords=${keywords}`);
    request.send();

    console.log("requete envoyée");

}

function display_results() {
    console.log(request.response);
}