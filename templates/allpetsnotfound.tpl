<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-4 mb-4 mt-md-5 mb-md-5 lastPetsTitle">Últimas mascotas perdidas</h1>
    </div>
    <div class="row">
        {foreach from=$petsToShow item=pet}
            {include 'petcard.tpl'}
        {/foreach}
    </div>
    <div class="mb-3 text-right">
        {if $amount > 0}
            {if $isAdminPage == true}
                <a href="admin/{$amount - 12}" class="btn btn-secondary text-white"><< Anteriores</a>
                <a href="admin" class="btn btn-secondary text-white">Portada</a>
            {else}
                <a href="home/{$amount - 12}" class="btn btn-secondary text-white"><< Anteriores</a>
                <a href="home" class="btn btn-secondary text-white">Portada</a>
            {/if}
        {/if}
        {if ($amount + 12) < $pets|count}
            {if $isAdminPage == true}
                <a href="admin/{$amount + 12}" class="btn btn-secondary text-white">Siguientes >></a>
            {else}
                <a href="home/{$amount + 12}" class="btn btn-secondary text-white">Siguientes >></a>
            {/if}
        {/if}
    </div>
</section>