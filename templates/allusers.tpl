<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-4 mb-4 mt-md-5 mb-md-5 lastPetsTitle">Usuarios de PetFinder</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead class="bg-orange">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$users item=user}
                <tr scope="row">
                    <td class="align-middle">{$user->name}</td>
                    <td class="align-middle">{$user->email}</td>
                    <td class="align-middle">
                        <div class="text-center">
                            <a href="modificar-permiso-usuario/{$user->id}/1" class="btn bg-success text-white mb-1 mb-md-0">Promover</a>
                            <a href="modificar-permiso-usuario/{$user->id}/2" class="btn bg-orange text-white mb-1 mb-md-0">Degradar</a>
                            <a href="eliminar-usuario/{$user->id}" class="btn bg-red text-white mb-1 mb-md-0">Eliminar</a>
                        </div>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</section>