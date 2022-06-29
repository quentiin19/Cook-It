//création de la requete
const request = new XMLHttpRequest;



//document elements
const msg_input = document.getElementById("message-input");
const send_btn = document.getElementById("send-message");


//variables
const id_sender = document.getElementById("id-sender").innerText;
const token = document.getElementById("id-receveur").innerText;
const id_receveur = document.getElementById("token").innerText;


//listener
send_btn.addEventListener("click", sendMsg);


function sendMsg(){
    let msg = msg_input.value;

    if(msg.length > 0){
        request.addEventListener("load", displayMsg);
        request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=write&msg=${msg}&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
        request.send();
    }
}

function displayMsg() {
    request.addEventListener("load", function(){
        
        console.log(JSON.parse(request.response));
    });
    request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=read&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
    request.send();
}

displayMsg();