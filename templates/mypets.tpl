<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-4 mb-4 mt-md-5 mb-md-5 lastPetsTitle">Mis mascotas perdidas</h1>
    </div>
    <div class="row">
        {if $pets|count == 0}
            <p class="lastPetsTitle">Aún no tienes mascotas perdidas, ¿acabás de perder una? Lo sentimos, ¡agrégala a PetFinder para advertir al resto!</p>
        {else if}
            {foreach from=$pets item=pet}
                {include 'petcard.tpl'}
            {/foreach}
        {/if}
    </div>
</section>