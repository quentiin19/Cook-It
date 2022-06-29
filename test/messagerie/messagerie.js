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
    console.log(msg);

    if(msg.length > 0){
        console.log('envoi du message');
        request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=write&msg=${msg}&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
        request.send();
    }
}

//https://cookit.ovh/test/messagerie/api_msg.php?task=write&msg=$&sender=&receiver=$&token=

function displayMsg() {
    request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=read&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
    request.send();
}

function refresh() {
    displayMsg();
    console.log("refreshed");
    setTimeout(refresh, 2000);
}

refresh();