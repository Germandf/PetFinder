<section class="container">
    <div class="row">
        <div class="col-12 mt-5 text-center">
            <form class="form-signin text-left shadow rounded" action="verify" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Iniciar sesión</h1>
                <label for="inputEmail" class="sr-only mt-3 ">Email</label>
                <input type="email" id="inputEmail" name="email" class="mt-3 form-control" placeholder="Email" required="" autofocus="">
                <label for="inputPassword" class="sr-only mt-3 ">Contraseña</label>
                <input type="password" id="inputPassword" name="password"  class="mt-3 form-control" placeholder="Contraseña" required="">
                <div class="checkbox mb-3 mt-3">
                    <label>
                        <input type="checkbox" value="remember-me">Recuerdame
                    </label>
                </div>
                <div class="d-block text-right">
                    <button class="mt-2 text-white btn-lg bg-orange-dark rounded border-none" type="submit">Iniciar</button>
                </div>
                {if isset($error)}
                <div class="alert alert-danger mt-2">
                    {$error}
                </div>
                {/if}
            </form>
        </div>
    </div>
</section>