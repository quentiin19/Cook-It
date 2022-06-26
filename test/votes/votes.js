let request = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const votes = document.getElementById("1")
const downvote = document.getElementById("downvote-1")

console.log("test");


upvote.addEventListener("click", function(){
    vote(1);
});

downvote.addEventListener("click", function(){
    vote(-1);
})


function vote(number){


    var session = '<%= Session["id"] %>';
    console.log(session);

    request.addEventListener("load", display_results);
    request.open("GET", `http://51.255.172.36/test/votes/api_vote?action=${number}&action=1`);
    request.send();
}