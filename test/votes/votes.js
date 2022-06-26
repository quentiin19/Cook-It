let request = new XMLHttpRequest;

const upvote = document.getElementById("upvote-1")
const vote = document.getElementById("1")
const downvote = document.getElementById("downvote-1")

console.log("test");


upvote.addEventListener("click", function(){
    vote(1);
});

downvote.addEventListener("click", function(){
    vote(-1);
})


function vote(number){
    console.log(number)
}