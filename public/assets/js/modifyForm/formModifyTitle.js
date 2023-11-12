const title = document.getElementById("formTitle");
title.addEventListener("input", () => {
    document.getElementById("title").value = title.innerText;
    const form = document.getElementById("formToModifyTitle");
    form.style.visibility = "visible";
});
