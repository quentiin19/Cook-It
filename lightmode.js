// function switchTheme(theme_add, theme_rm) {
//     const lightText = document.body.querySelectorAll(theme_rm);

//     for (let index = 0; index < lightText.length; index++) {
//         const element = lightText[index];
//         element.classList.remove(theme_rm);
//         element.classList.add(theme_add);
//     }
// }


const btn = document.getElementById('switch-mode');

const div = document.querySelectorAll("bg-color");

<<<<<<< HEAD
console.log(div);
=======
btn.addEventListener('click', function () {
    document.body.classList.toggle('bg-color-light');
    let theme = "dark";

    if (document.body.classList.contains('bg-color')) {
        theme = 'dark';
        switchTheme('bg-color-light', 'bg-color');
        
    } else {
        theme = "light";
        switchTheme('bg-color', 'bg-color-light');
    }
    localStorage.setItem('theme', theme);
})


const localTheme = localStorage.getItem('theme');

if (localTheme == 'light') {
    document.body.classList.add('light-theme');
    btn.setAttribute('checked', 'true');
    switchTheme('text-dark', 'text-light');

}
if (localTheme == 'dark') {
    document.body.classList.remove('light-theme');
    btn.removeAttribute('bg-color');
    switchTheme('text-light', 'text-dark');

}
>>>>>>> 15d0e9826cb3c8d3484ea396bd00a182ad0526a0



