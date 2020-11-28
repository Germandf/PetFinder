<!-- Si estamos editando, tomamos los valores de la DB. En el caso de los selects, seleccionamos por defecto el que sea igual al asignado a la mascota (si esta editando) -->
<div class="row">
    <div class="col-12 mt-5 text-center">
        <!-- Consulta si esta editando o agregando una mascota y lo envia a la URL correspondiente -->
        {if isset($pet)}
        <form id="addPetForm" method="post" enctype= "multipart/form-data" action="actualizar-mascota/{$pet->id}" class="form-signin text-left shadow rounded">
        {else}
        <form id="addPetForm" method="post" enctype= "multipart/form-data" action="insertar-mascota" class="form-signin text-left shadow rounded">
        {/if}
            <!-- Muestra el titulo correspondiente -->
            {if isset($pet)}
            <h1 class="h3 mb-3 font-weight-normal">Editar mascota</h1>
            {else}
            <h1 class="h3 mb-3 font-weight-normal">Añadir mascota</h1>
            {/if}
            <!-- Pet -->
            <label for="inputName" class="sr-only mt-3 ">Nombre</label>
            {if isset($pet)}
            <input id="inputName" value="{$pet->name}" type="text" class="mt-3 form-control" placeholder="Nombre" required autofocus="" name="name">
            {else}
            <input id="inputName" type="text" class="mt-3 form-control" placeholder="Nombre" required autofocus="" name="name">
            {/if}
            <!-- City -->
            <label for="inputCity" class="sr-only mt-3 ">Ciudad</label>
            <select id="inputCity" class="d-inline form-control mt-3" name="city">
                <option value="none" selected disabled hidden>Ciudad</option>
                {if isset($pet)}
                    {foreach from=$cities item=city}
                        {if $city->name eq $pet->city }
                        <option selected value="{$city->id}">{$city->name}</option>
                        {else}
                        <option value="{$city->id}">{$city->name}</option>
                        {/if}
                    {/foreach}
                {else}
                    {foreach from=$cities item=city}
                    <option value="{$city->id}">{$city->name}</option>
                    {/foreach}
                {/if}
            </select>
            <!-- Pet Type -->
            <label for="inputAnimalType" class="sr-only mt-3 ">Tipo de animal</label>
            <select id="inputAnimalType" class="d-inline form-control mt-3" required name="animalType">
                <option value="none" selected disabled hidden>Tipo de mascota</option>
                {if isset($pet)}
                    {foreach from=$animaltypes item=animalType}
                    {if $animalType->name eq $pet->animalType }
                    <option selected value="{$animalType->id}">{$animalType->name}</option>
                    {else}
                    <option value="{$animalType->id}">{$animalType->name}</option>
                    {/if}
                    {/foreach}
                {else}
                    {foreach from=$animaltypes item=animalType}
                    <option value="{$animalType->id}">{$animalType->name}</option>
                    {/foreach}
                {/if}
            </select>
            <!-- Gender -->
            <label for="inputGenderType" class="sr-only mt-3 ">Genero</label>
            <select id="inputGenderType" class="d-inline form-control mt-3" required name="gender">
                <option value="none" selected disabled hidden>Genero</option>
                {if isset($pet)}
                    {foreach from=$genders item=gender}
                        {if $gender->name eq $pet->gender }
                        <option selected value="{$gender->id}">{$gender->name}</option>
                        {else}
                        <option value="{$gender->id}">{$gender->name}</option>
                        {/if}
                    {/foreach}
                {else}
                    {foreach from=$genders item=gender}
                    <option value="{$gender->id}">{$gender->name}</option>
                    {/foreach}
                {/if}
            </select>
            <!-- Lost Date -->
            <label for="inputDateTime" class="sr-only mt-3 ">Fecha de extravio</label>
            {if isset($pet)}
            <input id="inputDateTime"  value="{$pet->date}" required type="date" class="mt-3 form-control" placeholder="Fecha de extravio" autofocus="" name="date">
            {else}
            <input id="inputDateTime"  required type="date" class="mt-3 form-control" placeholder="Fecha de extravio" autofocus="" name="date">
            {/if}
            <!-- Phone Number -->
            <label for="inputPhone" class="sr-only mt-3 ">Teléfono</label>
            {if isset($pet)}
            <input id="inputPhone" type="number" value="{$pet->phoneNumber}" class="mt-3 form-control" placeholder="Teléfono" required autofocus="" name="phone">
            {else}
            <input id="inputPhone" type="number" class="mt-3 form-control" placeholder="Teléfono" required autofocus="" name="phone">
            {/if}
            <!-- Photo -->
            <div class="input-group mt-3">
                <div class="custom-file">
                    {if isset($pet)}
                    <input type="file" class="custom-file-input" id="photo" name="photo">
                    {else}
                    <input type="file" required class="custom-file-input" id="photo" name="photo">
                    {/if}
                    <label class="custom-file-label" for="photo">Elegir foto</label>
                </div>
                {if isset($pet)}
                    <img src="{$pet->photo}" class="w-100 mt-2" id="loadedPhoto">
                {else}
                    <img src="" class="w-100 mt-2" id="loadedPhoto">
                {/if}
            </div>
            <!-- Description -->
            <label for="inputDescription" class="sr-only mt-3 ">Descripción</label>
            {if isset($pet)}
            <textarea  id="inputDescription" required type="text" class="mt-3 form-control" placeholder="Descripción" autofocus="" name="description" maxlength="200">{$pet->description}</textarea>
            {else}
            <textarea  id="inputDescription" required type="text" class="mt-3 form-control" placeholder="Descripción" autofocus="" name="description" maxlength="200"></textarea>
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
<!-- Script para detectar cambio de foto -->
<script src="js/addpetform.js"></script>