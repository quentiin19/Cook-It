const div = document.getElementById("recettes");

console.log("linked");

for (const child of div.childNodes) {
    console.log(child);
    if((child.id % 2) == 0){
        child.hidden = true;
    }
}