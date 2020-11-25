<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-4 mb-4 mt-md-5 mb-md-5 lastPetsTitle">Últimas mascotas perdidas</h1>
    </div>
    <div class="row">
        {foreach from=$pets item=pet}
            {include 'petcard.tpl'}
        {/foreach}
    </div>
</section>