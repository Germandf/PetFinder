<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="home">PetFinder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="admin">Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="categorias">Categorías</a></li>
            <li class="nav-item"><a class="nav-link" href="about">Acerca de</a></li>
        </ul>
        <ul class="navbar-nav mr-right">
            {if !isset($isauth)}
                <li class="nav-item"><a class="nav-link" href="login">Iniciar Sesión</a></li>
                <li class="nav-item"><a class="nav-link" href="signup">Registrarse</a></li>
            {else}
                <li class="nav-item"><a class="nav-link" href="logout">Salir</a></li>
            {/if}
        </ul>
    </div>
</nav>