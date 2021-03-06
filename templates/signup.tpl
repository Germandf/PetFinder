<section class="container">
    <div class="row">
        <div class="col-12 mt-5 text-center">
            <form class="form-signin text-left shadow rounded" method="post" action="adduser">
                <h1 class="h3 mb-3 font-weight-normal">Registrarse</h1>

                <label for="inputName" class="sr-only mt-3 ">Nombre</label>
                <input type="text" id="inputName" name="name" class="mt-3 form-control" placeholder="Nombre" required="" autofocus="">

                <label for="inputSurname" class="sr-only mt-3 ">Apellido</label>
                <input type="text" id="inputUsername" name="surname"  class="mt-3 form-control" placeholder="Apellido" required="" autofocus="">

             
                <label for="inputEmail" class="sr-only mt-3 ">Email</label>
                <input type="email" id="inputEmail" name="email" class="mt-3 form-control" placeholder="Email" required="" autofocus="">
                
                <label for="inputPassword" class="sr-only mt-3 ">Contraseña</label>
                <input type="password" id="inputPassword" name="password" class="mt-3 form-control" placeholder="Contraseña" required="">
                
                <label for="inputPasswordRepeat" class="sr-only mt-3 ">Repetir contraseña</label>
                <input type="password" id="inputPasswordRepeat" name="passwordRepeat" class="mt-3 form-control" placeholder="Repetir contraseña" required="">
                
                <div class="d-block text-right">
                    <button class="mt-2  text-white btn-lg bg-orange" type="submit">Registrar</button>
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