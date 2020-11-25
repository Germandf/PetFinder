<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-4 mb-2 mt-md-5 mb-md-3 lastPetsTitle">Categorías</h1>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item  bg-orange text-white m-0">Tipo de animal</li>
                {foreach from=$animaltypes item=animaltype}
                <li class="list-group-item">{$animaltype->name}</li>
                {/foreach}
            </ul>
        </div>
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item bg-orange text-white m-0">Ciudades</li>
                {foreach from=$cities item=city}
                <li class="list-group-item">{$city->name}</li>
                {/foreach}
            </ul>
        </div>
        <div class="col-12 col-md-6 mt-4">
            <ul class="list-group">
                <li class="list-group-item bg-orange text-white m-0">Género</li>
                {foreach from=$genders item=gender}
                <li class="list-group-item">{$gender->name}</li>
                {/foreach}
            </ul>
        </div>
    </div>
</section>