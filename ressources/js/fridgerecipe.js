//requete
const request = new XMLHttpRequest;

//elements du dom
const id = document.getElementById("id-user").innerText;
const recettes = document.getElementById("recettes");
const difficulty = document.getElementById("difficulty");

//écouteurs
difficulty.addEventListener("input", onchange);

function onchange() {
    //récupération de la valeur
    let dif = difficulty.value;

    //blocage de la difficulté entre 0 et 3
    if(dif > 3){
        difficulty.value = 3;
        dif = difficulty.value;
    }else if(dif < 0){
        difficulty.value = 0;
        dif = difficulty.value;
    }

    //envoi de la requete
    request.addEventListener("load", display_results_recipe);

    //configuration de la requete
    request.open("GET", `https://cookit.ovh/ressources/api/api_fridge_recipe.php?id=${id}&dif=${dif}`);
    request.send();
}

function display_results_recipe() {
    let recipes = JSON.parse(request.response);

    //remise à zero de la div
    recettes.innerText = "";

    //affichage des recettes
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
        title.setAttribute("class", "text-white");

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


//premier chargement
onchange();