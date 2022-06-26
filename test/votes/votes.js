let request = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const votes = document.getElementById("1")
const downvote = document.getElementById("downvote-1")
const id_user = document.getElementById("user_id");
const id_recipe = 67
const token = document.getElementById("user_token");

console.log("test");


upvote.addEventListener("click", function(){
    vote(1);
});

downvote.addEventListener("click", function(){
    vote(-1);
})


function vote(number){
    request.addEventListener("load", function(){
        displayVote(id_recipe);
    });
    request.open("GET", `http://51.255.172.36/test/votes/api_vote?action=2&vote=${number}&user=${id_user.innerText}&token=$${token.innerText}&recipe=${id_recipe}`);
    request.send();
}

function displayVote(recipe){
    
}