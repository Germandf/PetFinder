"use strict";

// Mantengo observado si el input file cambia de imagen
document.querySelector("#photo").onchange = function(e) { 
    readURL(this);
};

// Cambio la imagen
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector("#loadedPhoto").setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}