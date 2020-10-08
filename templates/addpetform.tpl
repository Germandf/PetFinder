<div class="row">
    <div class="col-12 mt-5 text-center">
        <form id="addPetForm" class="form-signin text-left shadow rounded">
            <h1 class="h3 mb-3 font-weight-normal">Añadir mascota</h1>

            <!-- Pet -->
            <label for="inputName" class="sr-only mt-3 ">Nombre</label>
            <input id="inputName" type="text" class="mt-3 form-control" placeholder="Nombre" required="" autofocus="" name="name">
            <!-- City -->
            <label for="inputCity" class="sr-only mt-3 ">Ciudad</label>
            <select id="inputCity" class="d-inline form-control mt-3" name="city">
                <option value="none" selected disabled hidden>Ciudad</option>
                <option value="tresarroyos">Tres Arroyos</option>
                <option value="tandil">Tandil</option>
                <option value="rauch">Rauch</option>
            </select>
            <!-- Pet Type -->
            <label for="inputAnimalType" class="sr-only mt-3 ">Email</label>
            <select id="inputAnimalType" class="d-inline form-control mt-3" name="animalType">
                <option value="none" selected disabled hidden>Tipo de mascota</option>
                <option value="dog">Perro</option>
                <option value="cat">Gato</option>
                <option value="other">Otro</option>
            </select>
            <!-- Gender -->
            <label for="inputGenderType" class="sr-only mt-3 ">Genero</label>
            <select id="inputGenderType" class="d-inline form-control mt-3" name="genderType">
                <option value="none" selected disabled hidden>Genero</option>
                <option value="male">Macho</option>
                <option value="female">Hembra</option>
            </select>
            <!-- Lost Date -->
            <label for="inputDateTime" class="sr-only mt-3 ">Fecha de extravio</label>
            <input id="inputDateTime" type="datetime-local" class="mt-3 form-control" placeholder="Fecha de extravio" autofocus="" name="date">
            <!-- Phone Number -->
            <label for="inputPhone" class="sr-only mt-3 ">Teléfono</label>
            <input id="inputPhone" type="text" class="mt-3 form-control" placeholder="Teléfono" required="" autofocus="" name="phone">
            <!-- Photo -->
            <div class="input-group mt-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="photo">
                    <label class="custom-file-label" for="inputGroupFile01">Elegir foto</label>
                </div>
            </div>
            <!-- Description -->
            <label for="inputDescription" class="sr-only mt-3 ">Descripción</label>
            <input id="inputDescription" type="text" class="mt-3 form-control" placeholder="Descripción" autofocus="" name="description">

            <div class="d-block text-right">
                <button class="mt-2  text-white btn-lg bg-orange" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>