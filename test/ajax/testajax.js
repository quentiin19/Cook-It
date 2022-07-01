const div = document.getElementById("recettes");

console.log("linked");

for (const child of div.childNodes) {
    console.log(child);
    if((child.innerText % 2) == 0){
        child.hidden = true;
    }
}