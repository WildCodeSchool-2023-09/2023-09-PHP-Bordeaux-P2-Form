function changeBackgroundColor() {
    var backgroundDiv = document.getElementById('backgroundDiv');
    var color = document.getElementById('background').value;
    backgroundDiv.style.backgroundColor = color;
    }

function changeTextColor() {
    var textColorDiv = document.getElementById('textColorDiv');
    var color = document.getElementById('police_color').value;
    textColorDiv.style.color = color;
    }

function changeTextSize() {
    var fontSizeDiv = document.getElementById('fontSizeDiv');
    var size = document.getElementById('police_size').value;
    var selectedSize = document.getElementById('selected_size');
    selectedSize.innerText = size;
    }