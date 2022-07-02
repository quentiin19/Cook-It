//requetes
const request_ajax = new XMLHttpRequest;

//elements du dom
const search_bar_ingredients = document.getElementById("search-bar-ingredient");
const ingredients_php = document.getElementById("ingredients-php");
const ingredients = document.getElementById("ingredients");


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
    var keywords = clean_str_ajax(search_bar_ingredients.value);

    //envoi de la requete
    request_ajax.addEventListener("load", display_results_ingredient);
    //configuration de la requete
    request_ajax.open("GET", `https://cookit.ovh/ressources/api/api.php?keywords=${keywords}&action=2`);
    request_ajax.send();


}


function display_results_ingredient(){
    ingredients.innerText = "";
    if(keywords == ""){
        next_prev.hidden = false;
        for (const ingredient_php of ingredients_php.childNodes){
            ingredient_php.hidden = false;
        }
    }else{
        next_prev.hidden = true;
        for (const ingredient_php of ingredients_php.childNodes){
            recingredient_phpipe.hidden = true;
        }

        let ingredients_resp = JSON.parse(request_ajax.response);
        console.log(ingredients_resp);


        console.log(ingredients.children);
        console.log(ingredients.childNodes);
        //afficher tous les éléments présents dans ingredients_resp
        for (const element of ingredients.childNodes) {
            for (const ingredient of ingredients_resp) {
                console.log(`${element.id} -- ${ingredient['ID']}`);
                if(element.id == ingredient['ID']){
                    element.hidden = false;
                    break;
                }
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


console.log("ouais");