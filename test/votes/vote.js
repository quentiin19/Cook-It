let request = new XMLHttpRequest;
let request2 = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const votes = document.getElementById("votes")
const downvote = document.getElementById("downvote-1")

//récupération des variables
const id_user = document.getElementById("user-id");
const id_recipe = document.getElementById("id-recette").innerText;
const token = document.getElementById("user-token");


console.log(id_recipe);

upvote.addEventListener("click", function(){
    vote_recipe(1);
});

downvote.addEventListener("click", function(){
    vote_recipe(-1);
})


function vote_recipe(number){

    request.addEventListener("load", function(){
        getVote(id_recipe);
    });
    request.open("GET", `https://cookit.ovh/test/votes/api_vote.php?action=2&vote=${number}&user=${id_user.innerText}&token=${token.innerText}&recipe=${id_recipe}`);
    request.send();
    console.log("requete envoyée");
}

function getVote(recipe){
    request2.addEventListener("load", function(){
        displayVote();
    });
    request2.open("GET", `https://cookit.ovh/test/votes/api_vote.php?action=1&recipe=${id_recipe}`);
    request2.send();
}

function displayVote() {
    let response = JSON.parse(request2.response);
    console.log(response.children[0]);

    votes.innerText = response.vote;

}

getVote(id_recipe);