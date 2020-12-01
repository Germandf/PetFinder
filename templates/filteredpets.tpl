<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-5 mb-4 lastPetsTitle">Mascotas filtradas</h1>
    </div>
    <div class="row">
        {foreach from=$petsToShow item=pet}
            {include 'petcard.tpl'}
        {/foreach}
    </div>
    <div class="mb-3 text-right">
        {if $amount > 0}
            <a href="filtrar/{$amount - 12}?{$query}" class="btn bg-gray text-white"><< Anteriores</a>
            <a href="filtrar?{$query}" class="btn bg-gray text-white">Portada</a>
        {/if}
        {if ($amount + 12) < $pets|count}
            <a href="filtrar/{$amount + 12}?{$query}" class="btn bg-gray text-white">Siguientes >></a>
        {/if}
    </div>
</section>