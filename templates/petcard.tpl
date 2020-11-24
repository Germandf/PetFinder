<div class="col-12 mb-3 col-md-6 col-xl-4">
    <div class="card shadow">
        <a href="ver/{$pet->id}"><img class="card-img-top imgPetCard" src="{$pet->photo}" alt="{$pet->name}'s image"></a>
        <div class="card-body">
            <h3 class="card-title">{$pet->name}</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item pl-0">Perdido en: {$pet->city}</li>
                <li class="list-group-item pl-0">El día: {$pet->date}</li>
                <li class="list-group-item pl-0">{$pet->animalType}</li>
            </ul>
            <div class="text-right">
                <a href="ver/{$pet->id}" class="btn bg-orange-dark text-white">Ver más</a>
                {if isset($smarty.session.ID_USER) && ($pet->userId == $smarty.session.ID_USER || $smarty.session.PERMISSION_USER == 1)}
                    <a href="editar/{$pet->id}" class="btn bg-orange text-white">Editar</a>
                    <a href="encontrar/{$pet->id}" class="btn bg-orange text-white">Lo encontré</a>
                {/if} 
            </div>
            {if isset($smarty.session.ID_USER) && $smarty.session.PERMISSION_USER == 1}
            <div class="text-right">
                <a href="eliminar/{$pet->id}" class="btn bg-red text-white mt-1">Eliminar</a>
            </div>
            {/if}
        </div>
    </div>
</div>