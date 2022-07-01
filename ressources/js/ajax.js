//requetes
const request_ajax = new XMLHttpRequest;
const request_admin = new XMLHttpRequest;

console.log("testes");
//elements du dom
const search_bar_recipes = document.getElementById("search-bar-recipe");
const result_ajax = document.getElementById("result-ajax");
const recettes = document.getElementById("recettes");

const search_bar_ingredients = document.getElementById("search-bar-ingredient");
const ingredients = document.getElementById("ingredients");

//écouteurs
if (search_bar_recipes === null) {
    search_bar_recipes.addEventListener("input", onclickrecipe);
}
if (search_bar_ingredients === null){
    search_bar_ingredients.addEventListener("input", onclickingredients);
}

//variable
const id = document.getElementById("id-user").innerText;
const token = document.getElementById("token-user").innerText;
let adminDisplay = 0;



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
    console.log("maj");
    //récupération de la valeur dans la barre de recherche
    var keywords = clean_str_ajax(search_bar_recipes.value);

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_ingredient);
    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=2`);
    request_ajax.send();


}


function display_results_ingredient() {
    console.log(JSON.parse(request_ajax.response));

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
    }









    // for (const ingredient of ingredients_resp){
    //     const main_div = document.createElement("div");
    //     main_div.setAttribute("class", "col-lg-12 col-md-12 col-sm-12 background-body arrondie my-2");

    //     const second_div = document.createElement("div");
    //     second_div.setAttribute("class", "row align-items-center");

    //     const checkbox_div = document.createElement("div");
    //     checkbox_div.setAttribute("class", "col-lg-1 col-md-1 col-sm-6");

    //     const checkbox = document.createElement("input");
    //     checkbox.setAttribute("type", "checkbox");
    //     checkbox.setAttribute("name", `checkbox${ingredient['ID']}`);

    //     checkbox_div.appendChild(checkbox);


    //     const img_div = document.createElement("div");
    //     img_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-6");

    //     const img = document.createElement("img");
    //     img.setAttribute("src", `${ingredient['PICTURE_PATH']}`);
    //     img.setAttribute("height", "70vh");
    //     img.setAttribute("width", "70vw");

    //     img_div.appendChild(img);


    //     const name_div = document.createElement("div");
    //     name_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");

    //     const name = document.createElement("p");
    //     name.innerText = `${ingredient['NAME']}`;

    //     name_div.appendChild(name);


    //     const quantity_div = document.createElement("div");
    //     quantity_div.setAttribute("class", "col-lg-3 col-md-2 col-sm-6");

    //     const quantity = document.createElement("input");
    //     quantity.setAttribute("class", "input-width text-dark");
    //     quantity.setAttribute("type", "text");
    //     quantity.setAttribute("name", `quantity${ingredient['ID']}`);
    //     quantity.setAttribute("placeholder", "quantité");

    //     quantity_div.appendChild(quantity);


    //     const unit_div = document.createElement("div");
    //     unit_div.setAttribute("class", "col-lg-2 col-md-3 col-sm-3");
    //     unit_div.innerText = `${ingredient['UNIT']}`;


    //     second_div.appendChild(checkbox_div);
    //     second_div.appendChild(img_div);
    //     second_div.appendChild(name_div);
    //     second_div.appendChild(quantity_div);
    //     second_div.appendChild(unit_div);

    //     main_div.appendChild(second_div);

    //     ingredients.appendChild(main_div);

//=====================================================================
        

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
    //}
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


 //---------------------------------------------------------------



        //          <div class="col-lg-3 col-md-4 col-sm-1 py-3">
        //             <div class="card mb-4 shadow-sm bg-color py-3 px-3 arrondie">
        //                 <a href="https://cookit.ovh/recette.php?id='.$recipe['ID_RECIPE'].'">
        //                 <img src="'.$recipe['PICTURE_PATH'].'" class="card-img-top cardh"> </img>
        //                 <div class="card-body text-center arrondie">
//                             <h4 class="text-white">'.$recipe['TITLE'].'</h4>
//                             <a href="https://cookit.ovh/profil.php?id='.$recipe['ID_CREATOR'].'" class=" btn btn-secondary" style="height : 30px"><p>Créé par '.$recipe['PSEUDO'].'</p></a>
        //                 </div>';
        //                 if (isAdmin()){
        //                     echo'<div class="text-right">
        //                             <a href="https://cookit.ovh/delRecette.php?id='.$recipe['ID_RECIPE'].'">
                                        //     <button type="button" class="btn btn-danger px-3">
                                        //         <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                        //     </button>
                                        // </a>
        //                         </div>';
        //                 }
                        
        //                 echo'</a>        
        //             </div>
        //         </div>'




        // const fourth_div = document.createElement("div");
        // fourth_div.setAttribute("class", "row");

        // const fifth_div = document.createElement("div");
        // fifth_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");

        // const sixth_div = document.createElement("div");
        // sixth_div.setAttribute("class", "col-lg-6 col-md-6 col-sm-6 px-2 py-2 border");
        // sixth_div.setAttribute("height", "100px");

        // const crjeator = document.createElement("p");
        // creator.innerText = `Créé par ${recipe['PSEUDO']}`;

        // const seventh_div = document.createElement("div");
        // seventh_div.setAttribute("class", "col-lg-3 col-md-3 col-sm-3");


        // sixth_div.appendChild(title);
        // sixth_div.appendChild(creator);

        // fourth_div.appendChild(fifth_div);
        // fourth_div.appendChild(sixth_div);
        // fourth_div.appendChild(seventh_div);

        // third_div.appendChild(fourth_div);

        // a.appendChild(img);
        // a.appendChild(third_div);

        // second_div.appendChild(a);

        // main_div.appendChild(second_div);

        // recettes.appendChild(main_div);

       
    }
}



function changeAdminDP(){
    adminRespons = JSON.parse(request_admin.response);
    console.log(request_admin.response);
    if (adminRespons == 1) {
        adminDisplay = 1;
    }
}


request_admin.addEventListener("load", changeAdminDP);
request_admin.open("GET", `https://cookit.ovh/ressources/api/api.php?action=3&id=${id}&token=${token}`);
console.log('eee');
request_admin.send();




/*
détection
*/