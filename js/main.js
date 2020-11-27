$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $('.custom-file-label').html(fileName);
});

let formComment = document.querySelector("#form-new-comment");
let petPage = document.querySelector("#pet-page");

if(petPage){ //Si estamos en la pagina de comentarios
    getComments();

    let urlComment = "api/comentarios"; 
    if(formComment){
        formComment.addEventListener("submit", (event)=>{
            //Envio el comentario a la base de datos
            event.preventDefault();
            var data = new FormData(formComment);
    
            fetch(urlComment, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},       
                body: JSON.stringify(Object.fromEntries(data))
            }).then(Response=>{
                if(Response.status = 200){
                    getComments();
                }
            });
        });
    }
    
    


    let app = new Vue({
        el: "#comments",
        data: {
            comments: [] 
        },
        methods: {
            remove: function (event) {
                event.preventDefault();
                let dataId = event.currentTarget.getAttribute("data-id");
                removeMessage(dataId);
            }
          }
        
    });

    function removeMessage(idPet){
        fetch(`api/comentarios/${idPet}`,{
            method: "DELETE"
        }).then(Response=>{
            if(Response.status = 200){
                getComments();
            }
        });
    }
    function getComments() {
        
        let idPet = petPage.getAttribute("data-id");
        fetch(`api/comentarios/${idPet}`)
        .then(response => {
            if(response.status = 200){
                return response.json()
            }
        })
        .then(comments => {
            app.comments = comments; 
        })
        .catch(()=>{
            app.comments = [];
        });
    }
    
}


