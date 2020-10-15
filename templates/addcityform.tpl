<!-- Si estamos editando, tomamos los valores de la DB -->

<div class="row">
    <div class="col-12 mt-5 text-center">
        <!-- Consulta si esta editando o agregando una ciudad y lo envia a la URL correspondiente -->
        {if isset($city)}
        <form id="addcityForm" method="post"  enctype="multipart/form-data" action="actualizar-ciudad/{$city->id}" class="form-signin text-left shadow rounded">
        {else}
        <form id="addcityForm" method="post"  enctype="multipart/form-data" action="insertar-ciudad" class="form-signin text-left shadow rounded">
        {/if}
            <!-- Muestra el titulo correspondiente -->
            {if isset($city)}
            <h1 class="h3 mb-3 font-weight-normal">Editar ciudad</h1>
            {else}
            <h1 class="h3 mb-3 font-weight-normal">Añadir ciudad</h1>
            {/if}
            <!-- City -->
            <label for="inputName" class="sr-only mt-3 ">Nombre</label>
            {if isset($city)}
            <input id="inputName" value="{$city->name}" type="text" class="mt-3 form-control" placeholder="Nombre" required autofocus="" name="name">
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