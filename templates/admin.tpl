{include 'header.tpl'}
{include 'navbar.tpl'}

{include 'adminmenu.tpl'}
<section class="container">
    <div class="row">
        {include 'animaltypeslist.tpl'}
        {include 'citieslist.tpl'}
    </div>
</section>
<section class="container">
    <div class="row justify-content-center">
        <h1 class="mt-5 mb-4 lastPetsTitle">Últimas mascotas perdidas</h1>
    </div>
    {include 'allpets.tpl'}
</section>

{include 'footer.tpl'}