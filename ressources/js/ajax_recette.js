//requetes
const request_ajax = new XMLHttpRequest;
const request_admin = new XMLHttpRequest;

console.log("testes");
//elements du dom
const search_bar_recipes = document.getElementById("search-bar-recipe");
const result_ajax = document.getElementById("result-ajax");
const recettes = document.getElementById("recettes");
const recettes_php = document.getElementById("recettes-php");
const next_prev = document.getElementById("next-prev");





//écouteur
search_bar_recipes.addEventListener("input", onclickrecipe);

//variable
const id = document.getElementById("id-user").innerText;
const token = document.getElementById("token-user").innerText;
let adminDisplay = 0;
let keywords = '';





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




function onclickrecipe() {
    //récupération de la valeur dans la barre de recherche
    keywords = clean_str_ajax(search_bar_recipes.value);

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_recipe);

    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=1`);
    request_ajax.send();
}

function display_results_recipe() {
    if(keywords == ""){
        recettes.innerText = "";
        next_prev.hidden = false;
        for (const recipe of recettes_php.childNodes){
            recipe.hidden = false;
        }
    }else{
        next_prev.hidden = true;
        for (const recipe of recettes_php.childNodes){
            recipe.hidden = true;
        }
    

        let recipes = JSON.parse(request_ajax.response);
        console.log(recipes);

        for (const recipe of recipes) {
            console.log(recipe);
            
            const main_div = document.createElement("div");
            main_div.setAttribute("class", "col-lg-3 col-md-4 col-sm-1 py-3");

            const second_div = document.createElement("div");
            second_div.setAttribute("class", "card mb-4 shadow-sm bg-color py-3 px-3 arrondie");

            const a = document.createElement("a");
            a.setAttribute("href", `https://cookit.ovh/recette.php?id=${recipe['ID_RECIPE']}`);

            const img = document.createElement("img");
            img.setAttribute("src", `${recipe['PICTURE_PATH']}`);
            img.setAttribute("class", "card-img-top cardh");

            const title_div = document.createElement("div");
            title_div.setAttribute("class", "card-body text-center arrondie");

            const title = document.createElement("h4");
            title.innerText = `${recipe['TITLE']}`;

            const creator = document.createElement("a");
            creator.setAttribute("href", `https://cookit.ovh/profil.php?id=${recipe['ID_CREATOR']}`);
            creator.setAttribute("class", "btn btn-secondary");
            creator.setAttribute("style", "height : 30px;");
            creator.innerHTML = `<p>Créé par ${recipe['PSEUDO']}</p>`;

            title_div.appendChild(title);
            title_div.appendChild(creator);



            const admin_div = document.createElement("div");
            admin_div.setAttribute("class", "text-right");

            if (adminDisplay === 1){

                const aAdmin = document.createElement("a");
                aAdmin.setAttribute("href", `https://cookit.ovh/delRecette.php?id=${recipe['ID_RECIPE']}`);

                const btnAdmin = document.createElement("button");
                //---------------------------------------------------------------
                btnAdmin.setAttribute("class", "btn btn-danger px-3");
                btnAdmin.innerHTML = '<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>';

                admin_div.appendChild(aAdmin);
                admin_div.appendChild(btnAdmin);
            }

            a.appendChild(img);
            a.appendChild(title_div);
            a.appendChild(admin_div);

            second_div.appendChild(a);
            main_div.appendChild(second_div);

            recettes.appendChild(main_div);
        }
    }
}

function changeAdminDP(){
    adminRespons = JSON.parse(request_admin.response);
    console.log(request_admin.response);
    if (adminRespons == 1) {
        adminDisplay = 1;
    }
}

if(adminDisplay == 0){
    request_admin.addEventListener("load", changeAdminDP);
    request_admin.open("GET", `https://cookit.ovh/ressources/api/api.php?action=3&id=${id}&token=${token}`);
    request_admin.send();

}
