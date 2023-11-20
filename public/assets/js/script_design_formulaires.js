document.addEventListener("DOMContentLoaded", function () {
    
    var backgroundInput = document.getElementById("background");
    var policeColorInput = document.getElementById("police_color");
    var policeSizeInput = document.getElementById("police_size");
    var policeStyleSelect = document.getElementById("police");
    var selectedSizeSpan = document.getElementById("selected_size");

    var exempleDiv = document.querySelector(".exemple");

    backgroundInput.addEventListener("input", updateExample);
    policeColorInput.addEventListener("input", updateExample);
    policeSizeInput.addEventListener("input", updateExample);
    policeStyleSelect.addEventListener("change", updateExample);

    function updateExample() {
    
        var backgroundColor = backgroundInput.value;
        var policeColor = policeColorInput.value;
        var policeSize = policeSizeInput.value;
        var policeStyle = policeStyleSelect.value;

        exempleDiv.style.backgroundColor = backgroundColor;
        exempleDiv.style.color = policeColor;
        exempleDiv.style.fontSize = policeSize + "px";
        exempleDiv.style.fontFamily = policeStyle;

        selectedSizeSpan.textContent = policeSize;
    }
});
