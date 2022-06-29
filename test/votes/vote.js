let request = new XMLHttpRequest;
let request2 = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const votes = document.getElementById("1")
const downvote = document.getElementById("downvote-1")

const id_user = document.getElementById("user_id");
const id_recipe = 67
const token = document.getElementById("user_token");


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
    console.log(request2.response);

    votes.innerText  = request2.response;
}

getVote(id_recipe);