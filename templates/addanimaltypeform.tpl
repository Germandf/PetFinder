<!-- Si estamos editando, tomamos los valores de la DB -->

<div class="row">
    <div class="col-12 mt-5 text-center">
        <!-- Consulta si esta editando o agregando una ciudad y lo envia a la URL correspondiente -->
        {if isset($animalType)}
        <form id="addAnimalTypeForm" method="post"  enctype="multipart/form-data" action="actualizar-tipo-de-animal/{$animalType->id}" class="form-signin text-left shadow rounded">
        {else}
        <form id="addAnimalTypeForm" method="post"  enctype="multipart/form-data" action="insertar-tipo-de-animal" class="form-signin text-left shadow rounded">
        {/if}
            <!-- Muestra el titulo correspondiente -->
            {if isset($animalType)}
            <h1 class="h3 mb-3 font-weight-normal">Editar tipo de animal</h1>
            {else}
            <h1 class="h3 mb-3 font-weight-normal">Añadir tipo de animal</h1>
            {/if}
            <!-- animalType -->
            <label for="inputName" class="sr-only mt-3 ">Nombre</label>
            {if isset($animalType)}
            <input id="inputName" value="{$animalType->name}" type="text" class="mt-3 form-control" placeholder="Nombre" required autofocus="" name="name">
            {else}
            <input id="inputName" type="text" class="mt-3 form-control" placeholder="Nombre" required autofocus="" name="name">
            {/if}
            <div class="d-block text-right">
                <button class="mt-2  text-white btn-lg bg-orange" type="submit">Confirmar</button>
            </div>
            {if isset($error)}
                <div class="alert alert-danger mt-2">
                    {$error}
                </div>
            {/if}
        </form>
    </div>
</div>