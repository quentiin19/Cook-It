const request_ajax = new XMLHttpRequest;

//elements du dom
const search_bar_recipes = document.getElementById("search-bar-recipe");
const result_ajax = document.getElementById("result-ajax");
const recettes = document.getElementById("recettes");

const search_bar_ingredients = document.getElementById("search-bar-recipe");
const ingredients = document.getElementById("ingredients");

//écouteur
search_bar.addEventListener("input", onclickrecipe);


function clean_str_ajax(str){
    let new_str = [];
    console.log(`uncleaned string : ${str}`);
    // let a = "àáâäAÀÁÂÄ";
    // let e = "èéêëEÈÉÊË";
    // let i = "ìíîïIÌÍÎÏ";
    // let o = "òóôöOÒÓÔÖ";
    // let u = "ùúûüUÙÚÛÜ";
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
            if(str[k] == ' '){
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

function onclickingredients() {
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str_ajax(search_bar_recipes.value);

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_ingredient);
    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=2`);
    request_ajax.send();


}


function display_results_ingredient() {
    ingredients.innerHTML = "";
    console.log(JSON.parse(request_ajax.response));

    let ingredients_resp = JSON.parse(request_ajax.response);
    console.log(ingredients_resp);

    for (const ingredient of ingredients_resp){
        const main_div = document.createElement("div");
        main_div.setAttribute("class", "col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2");

        const second_div = document.createElement("div");
        second_div.setAttribute("class", "row align-items-center");

        const checkbox_div = document.createElement("div");
        checkbox_div.setAttribute("class", "col-lg-1 col-md-1 col-sm-6");

        const checkbox = document.createElement("input");
        checkbox.setAttribute("type", "checkbox");
        checkbox.setAttribute("name", `checkbox${ingredient['ID']}`);

        checkbox_div.appendChild(checkbox);


        const img_div = document.createElement("div");
        img_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-6");

        const img = document.createElement("img");
        img.setAttribute("src", `${ingredient['PICTURE_PATH']}`);
        img.setAttribute("height", "70vh");
        img.setAttribute("width", "70vw");

        img_div.appendChild(img);


        const name_div = document.createElement("div");
        name_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");

        const name = document.createElement("p");
        name.innerText = `${ingredient['NAME']}`;

        name_div.appendChild(name);


        const quantity_div = document.createElement("div");
        quantity_div.setAttribute("class", "col-lg-3 col-md-2 col-sm-6");

        const quantity = document.createElement("input");
        quantity.setAttribute("class", "input-width text-dark");
        quantity.setAttribute("type", "text");
        quantity.setAttribute("name", `quantity${ingredient['ID']}`);
        quantity.setAttribute("placeholder", "quantité");

        quantity_div.appendChild(quantity);


        const unit_div = document.createElement("div");
        unit_div.setAttribute("class", "col-lg-2 col-md-3 col-sm-3");
        unit_div.innerText = `${ingredient['UNIT']}`;


        second_div.appendChild(checkbox_div);
        second_div.appendChild(img_div);
        second_div.appendChild(name_div);
        second_div.appendChild(quantity_div);
        second_div.appendChild(unit_div);

        main_div.appendChild(second_div);

        ingredients.appendChild(main_div);


        

        // <div class="col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2">
        //     <div class="row align-items-center">
        //         <div class="col-lg-1 col-md-1 col-sm-6">
        //             <input type="checkbox" name="checkbox'.$ingredient['ID'].'">
        //         </div>
        //         <div class="col-lg-3 col-md-3 col-sm-6">
        //             <img src="'.$ingredient['PICTURE_PATH'].'" height ="70vh" width="70vw"/>
        //         </div>
        //         <div class="col-lg-3 col-md-3 col-sm-3">
        //             <p>'.$ingredient['NAME'].'</p>
        //         </div>
        //         <div class="col-lg-3 col-md-2 col-sm-6 ">
        //             <input class="input-width text-dark" type="text" name="quantity'.$ingredient['ID'].'" placeholder="quantité">
        //         </div>
        //          <div class="col-lg-2 col-md-3 col-sm-3">
        //             '.$ingredient['UNIT'].'
        //         </div>		
        //     </div>
        // </div>
    }
}



function onclickrecipe() {
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str_ajax(search_bar_recipes.value);


    //envoi de la requete
    request_ajax.addEventListener("load", display_results_recipe);
    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=1`);
    request_ajax.send();
}

function display_results_recipe() {
    recettes.innerHTML = "";
    console.log(JSON.parse(request_ajax.response));

    let recipes = JSON.parse(request_ajax.response);
    console.log(recipes);

    for (const recipe of recipes) {
        const main_div = document.createElement("div");
        main_div.setAttribute("class", "col-lg-3 col-md-4 col-sm-1 py-3");

        const second_div = document.createElement("div");
        second_div.setAttribute("class", "card cardh mb-4 shadow-sm bg-color py-3 px-3 arrondie");
        second_div.setAttribute("style", "width: 35rem");


        const a = document.createElement("a");
        a.setAttribute("href", `https://cookit.ovh/recette.php?id=${recipe['ID_RECIPE']}`);

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