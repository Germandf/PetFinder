<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-5 mb-4 lastPetsTitle">Últimas mascotas perdidas</h1>
    </div>
    <div class="row">
        {foreach from=$pets item=pet}
        <div class="col-12 mb-3 col-md-6 col-lg-4">
            <div class="card shadow" >
                <img class="card-img-top" src="https://www.petrelocation.com/uploads/images/general/dog_1804690_1920.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="card-title">{$pet->name}</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item pl-0">Perdido en...{$pet->city_id}</li>
                        <li class="list-group-item pl-0">El dia...{$pet->date}</li>
                        <li class="list-group-item pl-0">{$pet->animal_type_id}</li>
                    </ul>
                    <div class="text-right">
                        <a href="editar/{$pet->id}" class="btn bg-orange-dark text-white">Editar</a>
                        <a href="encontrar/{$pet->id}" class="btn bg-orange text-white">Lo encontré</a>
                    </div>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
</section>