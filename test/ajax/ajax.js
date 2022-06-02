const request = new XMLHttpRequest;

const search_bar = document.getElementById("search_bar_ajax");
const search_button = document.getElementById("search_button_ajax");
const result_ajax = document.getElementById("result_ajax");

//récupération des coordonnées de la barre de recherche
var coor_sb = search_bar.getBoundingClientRect();

//écouteurs
search_button.addEventListener("click", onclick, false);


function onclick() {
    //récupération de la valeur dans la barre de recherche
    console.log("test");
    var keywords = search_bar.value;

    console.log(keywords);

    //envoi de la requete
    request.addEventListener("load", display_results);
    request.open("GET", `http://51.255.172.36/test/ajax/api.php?keywords=${keywords}`);
    request.send();

    console.log("requete envoyée");

}

function display_results() {
    console.log(request.responseXML.children[0]);
}