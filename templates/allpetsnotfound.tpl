<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-5 mb-4 lastPetsTitle">Últimas mascotas perdidas</h1>
    </div>
    <div class="row">
        {foreach from=$pets item=pet}
            {include 'petcard.tpl'}
        {/foreach}
    </div>
</section>