// function switchTheme(theme_add, theme_rm) {
//     const lightText = document.body.querySelectorAll(.${theme_rm});

//     for (let index = 0; index < lightText.length; index++) {
//         const element = lightText[index];
//         element.classList.remove(background-body);
//         element.classList.add(bg-light);
//     }
// }

function switchCards(theme) {
    const cards = document.querySelectorAll('.film');
    for (let index = 0; index < cards.length; index++) {
        const element = cards[index];
        if (theme == 'light') {
            element.classList.remove('custom-cards');
        }
        if (theme == 'dark') {
            element.classList.add('custom-cards');
        }
    }
}

const btn = document.querySelector('#darkSwitch');
const localTheme = localStorage.getItem('theme');

if (localTheme == 'light') {
    document.body.classList.add('light-theme');
    btn.setAttribute('checked', 'true');
    switchTheme('text-dark', 'text-light');
    switchCards('light');
}
if (localTheme == 'dark') {
    document.body.classList.remove('light-theme');
    btn.removeAttribute('checked');
    switchTheme('text-light', 'text-dark');
    switchCards('dark');
}


btn.addEventListener('click', function () {
    document.body.classList.toggle('light-theme');
    let theme = "dark";

    if (document.body.classList.contains('light-theme')) {
        theme = "light";
        switchTheme('text-dark', 'text-light');
        switchCards('light');
    } else {
        theme = 'dark';
        switchTheme('text-light', 'text-dark');
        switchCards('dark');
    }
    localStorage.setItem('theme', theme);
})