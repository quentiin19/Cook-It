let request = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const vote = document.getElementById("1")
const downvote = document.getElementById("downvote-1")


upvote.addEventListener("click", vote(3));


function vote(number){
    console.log(number)
}