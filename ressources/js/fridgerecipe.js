//requete
const request = new XMLHttpRequest;

//elements du dom
const id = document.getElementById("id-user");
const recettes = document.getElementById("recettes");
const difficulty = document.getElementById("difficulty");

//écouteurs
difficulty.addEventListener("input", function (){
    console.log("test");
    
})

function onclickrecipe() {
    //récupération de la valeur dans la barre de recherche
    keywords = search_bar_recipes.value;

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_recipe);

    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=1`);
    request_ajax.send();
}

function display_results_recipe() {
    recettes.innerText = "";
    if(keywords == ""){
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


            a.appendChild(img);
            a.appendChild(title_div);
            a.appendChild(admin_div);

            second_div.appendChild(a);
            main_div.appendChild(second_div);

            recettes.appendChild(main_div);
        }
    }
}
