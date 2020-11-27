<section class="container" id="pet-page" data-id="{$pet->id}">
    <a href="javascript:history.back()" class="btn bg-orange text-white my-2 w-100">Volver</a>
    <!-- Foto -->
    <div class="row">
        <div class="col-12 col-md-6">
            <img src="{$pet->photo}" alt="..." class="img-thumbnail mx-auto w-100">
        </div>
        <div class="col-12 col-md-6">
            <!-- Nombre -->
            <div class="row">
                <h1 class="mt-3 mx-4 petTitle">{$pet->name}</h1>
            </div>
            <!-- Descripcion -->
            <div class="row">
                <p class="mx-4">{$pet->description}</p>
            </div>
            <!-- Detalles -->
            <div class="row">
                <h3 class="mt-3 mx-4 petSubTitle">Detalles</h3>
            </div>
            <div class="row">
                <p class="mx-4">Tipo de animal: {$pet->animalType}</p>
            </div>
            <div class="row">
                <p class="mx-4">Ciudad: {$pet->city}</p>
            </div>
            <div class="row">
                <p class="mx-4">Género: {$pet->gender}</p>
            </div>
            <div class="row">
                <p class="mx-4">Fecha de extravío: {$pet->date}</p>
            </div>
            <!-- Contacto -->
            <div class="row">
                <h3 class="mt-3 mx-4 petSubTitle">Contacto</h3>
            </div>
            <div class="row">
                <p class="mx-4">Dueño: {$pet->userName}</p>
            </div>
            <div class="row">
                <p class="mx-4">Email: {$pet->userEmail}</p>
            </div>
            <div class="row">
                <p class="mx-4">Teléfono: {$pet->phoneNumber}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <h1> Comentarios </div>
        {include file="vue/comments.tpl"}
        <div class="mb-2 col-12">
            {if isset($smarty.session.ID_USER)}
                <form id="form-new-comment" class="g-bg-secondary rounded shadow mt-2 -100 text-left p-2 u-shadow-v18 ">
                    <p class="mt-2">Agregar nuevo comentario... </p>
                    <textarea class="w-100 p-2" type="text" id="message" name="message" maxlength="200"></textarea>
                    <p class="mt-2 mb-2">
                        <span class="mr-2">¿Que tan seguro estas de haberlo visto? </span> <input type="range" value="1" min="1" max="5" name="rate" id="rate">
                    <p>
                    <input type="number" name="petId" class="d-none" value="{$pet->id}"> 
                    <input type="submit" value="Comentar" class="btn bg-orange text-white mr-2 mt-1">
                </form>
            {/if}
        </div>
    </div>
    
</section>