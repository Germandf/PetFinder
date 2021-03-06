<nav class="navbar navbar-expand-lg navbar-dark bg-gray sticky-top">
    <a class="navbar-brand" href="home">PetFinder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {if isset($smarty.session.ID_USER)}
                {if isset($smarty.session.PERMISSION_USER) && $smarty.session.PERMISSION_USER == 1}
                <li class="nav-item"><a class="nav-link" href="admin">Admin</a></li>
                {/if}
                <li class="nav-item"><a class="nav-link" href="mis-mascotas">Mis Mascotas</a></li>
            {/if}
            <li class="nav-item"><a class="nav-link" href="categorias">Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="sobre-nosotros">Acerca de</a></li>
        </ul>
        <ul class="navbar-nav mr-right">
            {if !isset($smarty.session.ID_USER)}
                <li class="nav-item"><a class="nav-link" href="login">Iniciar Sesión</a></li>
                <li class="nav-item"><a class="nav-link" href="signup">Registrarse</a></li>
            {else}
                <li class="nav-item nav-link">¡Hola, {$smarty.session.NAME_USER}!</li>
                <li class="nav-item"><a class="nav-link" href="logout">Salir</a></li>
            {/if}
        </ul>
    </div>
</nav>