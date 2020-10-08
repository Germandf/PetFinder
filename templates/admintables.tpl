<section class="container">
    <div class="row">
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item  bg-orange text-white card-title m-0">Tipo de animal</li>
                {foreach from=$animaltypes item=animaltype}
                <li class="list-group-item">{$animaltype->name}</li>
                {/foreach}
            </ul>
        </div>
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item bg-orange text-white card-title m-0">Ciudades</li>
                {foreach from=$cities item=city}
                <li class="list-group-item">{$city->name}</li>
                {/foreach}
            </ul>
        </div>
    </div>
</section>