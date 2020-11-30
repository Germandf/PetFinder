<section class="container">
    <div class="row">
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item bg-orange text-white m-0">Ciudades</li>
                {foreach from=$cities item=city}
                <li class="list-group-item d-flex align-items-center">
                    <div class="col-6 text-left">{$city->name}</div>
                    <div class="col-6 text-right">
                        <a href="editar-ciudad/{$city->id}" class="btn bg-gray text-white">Editar</a>
                        <a href="eliminar-ciudad/{$city->id}" class="btn bg-red text-white">Eliminar</a>
                    </div>
                </li>
                {/foreach}
            </ul>
        </div>
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item  bg-orange text-white m-0">Tipo de animal</li>
                {foreach from=$animaltypes item=animaltype}
                <li class="list-group-item d-flex align-items-center">
                    <div class="col-6 text-left">{$animaltype->name}</div>
                    <div class="col-6 text-right">
                        <a href="editar-tipo-de-animal/{$animaltype->id}" class="btn bg-gray text-white">Editar</a>
                        <a href="eliminar-tipo-de-animal/{$animaltype->id}" class="btn bg-red text-white">Eliminar</a>
                    </div>
                </li>
                {/foreach}
            </ul>
        </div>
    </div>
</section>