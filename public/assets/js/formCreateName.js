const formTitle = document.getElementById("formName");
const divInfos = document.getElementById("formInfo");
const maxLength = 255;
formTitle.addEventListener("input", (event) => {
    let newLength = maxLength - formTitle.value.length;
    divInfos.innerText = "Il reste " + newLength + " caractère";
    if (newLength > 1) {
        divInfos.innerText += "s";
    }
});
