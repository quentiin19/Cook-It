//création de la requete
const request = new XMLHttpRequest;
let old_request = 0;

//document elements
const msg_input = document.getElementById("message-input");
const send_btn = document.getElementById("send-message");
const msg_canva = document.getElementById("message-canva");


//variables
const id_sender = document.getElementById("id-sender").innerText;
const id_receveur = document.getElementById("id-receveur").innerText;
const token = document.getElementById("token").innerText;


//listener
send_btn.addEventListener("click", sendMsg);



function sendMsg(){
    let msg = msg_input.value;
    console.log(msg);
    console.log(id_sender);
    console.log(id_receveur);
    console.log(token);

    if(msg.length > 0){
        console.log('envoi du message');
        request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=write&msg=${msg}&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
        request.send();
    }
}


function displayMsg() {
    request.open("GET", `https://cookit.ovh/test/messagerie/api_msg.php?task=read&sender=${id_sender}&receiver=${id_receveur}&token=${token}`);
    request.send();


    console.log(request.response);



    if (old_request != request.response) {
        //update de l'ancienne requete
        old_request = request.response;

        //clear de la canva
        msg_canva.innerText = "";

        //affichage des messages
        let old_msg = [0];
        for (const message in request.response) {
            if (old_msg['ID_SENDER'] != message['ID_SENDER']) {
                const group_msg = document.createElement("div");
                group_msg.setAttribute("class", "d-flex flex-row justify-content-start");

                const img_friend = document.createElement("img");
                img_friend.setAttribute("src", `https://cookit.ovh/ressources/images/avatars/${id_receveur}.png`)
                
                const
            }


            old_msg = message;
        } 
    }
}

function refresh() {
    displayMsg();
    console.log("refreshed");
    setTimeout(refresh, 2000);
}

refresh();