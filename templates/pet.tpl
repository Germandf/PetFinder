<section class="container">
    <a href="javascript:history.back()" class="btn bg-orange text-white my-2 w-100">Volver</a>
    <!-- Foto -->
    <div class="row">
        <div class="col-12">
        <img src="{$pet->photo}" alt="..." class="img-thumbnail mx-auto w-100">
        <div>
    </div>
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
</section>