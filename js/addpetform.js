"use strict";

document.addEventListener("DOMContentLoaded", function(e){
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

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
});