const request = new XMLHttpRequest;

const btn = document.getElementById('switch-mode');
const id = document.getElementById('id-user').value;



btn.addEventListener("click", onclickmode);

function onclickmode(){
    request.addEventListener("load", changemode);
    request.open("GET", `https://cookit.ovh/ressources/api/api_mode.php?id=${id}&action=change`);
    request.send();

}

function setupMode(){
    request.addEventListener("load", changemode);
    request.open("GET", `https://cookit.ovh/ressources/api/api_mode.php?id=${id}&action=get`);
    request.send();

}

function changemode(mode){
    const response = JSON.parse(request.response);
    console.log(response);
    let mode = response['MODE'];
    
    //mode = 1 = dark
    if(mode == 1){
        const divbg = document.querySelectorAll(".bg-color-light");
        for (const node of divbg) {
            node.classList.remove("bg-color-light");
            node.classList.add("bg-color");
        }
        const divbody = document.querySelectorAll(".background-body-light");
        for (const node of divbody) {
            node.classList.remove("background-body-light");
            node.classList.add("background-body");
        }

    //mode = 0 = sombre
    }else{
        const divbg = document.querySelectorAll(".bg-color");
        for (const node of divbg) {
            node.classList.remove("bg-color");
            node.classList.add("bg-color-light");
        }
        const divbody = document.querySelectorAll(".background-body");
        for (const node of divbody) {
            node.classList.remove("background-body");
            node.classList.add("background-body-light");
        }
    }
}



setupMode();




// function switchTheme(theme_add, theme_rm) {
//     const lightText = document.body.querySelectorAll(theme_rm);

//     for (let index = 0; index < lightText.length; index++) {
//         const element = lightText[index];
//         element.classList.remove(theme_rm);
//         element.classList.add(theme_add);
//     }
// }

// function switchCards(theme) {
//     const cards = document.querySelectorAll('.film');
//     for (let index = 0; index < cards.length; index++) {
//         const element = cards[index];
//         if (theme == 'light') {
//             element.classList.remove('custom-cards');
//         }
//         if (theme == 'dark') {
//             element.classList.add('custom-cards');
//         }
//     }
// }

// const btn = document.querySelector('#darkSwitch');
// const localTheme = localStorage.getItem('theme');

// if (localTheme == 'light') {
//     document.body.classList.add('light-theme');
//     btn.setAttribute('checked', 'true');
//     switchTheme('text-dark', 'text-light');
//     switchCards('light');
// }
// if (localTheme == 'dark') {
//     document.body.classList.remove('light-theme');
//     btn.removeAttribute('checked');
//     switchTheme('text-light', 'text-dark');
//     switchCards('dark');
// }


// btn.addEventListener('click', function () {
//     document.body.classList.toggle('light-theme');
//     let theme = "dark";

//     if (document.body.classList.contains('light-theme')) {
//         theme = "light";
//         switchTheme('text-dark', 'text-light');
//         switchCards('light');
//     } else {
//         theme = 'dark';
//         switchTheme('text-light', 'text-dark');
//         switchCards('dark');
//     }
//     localStorage.setItem('theme', theme);
// })