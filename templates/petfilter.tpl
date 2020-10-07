<section class="container-fluid bg-orange-dark ">
        <form id="petFilterForm" action="" method="get" class="row">
            <!-- City -->
            <div class="col-12 col-md-auto">
                <select id="inputCity" class="d-inline form-control mt-3" name="city">
                    <option value="none" selected disabled hidden>Ciudad</option>
                    <option value="tresarroyos">Tres Arroyos</option>
                    <option value="tandil">Tandil</option>
                    <option value="rauch">Rauch</option>
                </select>
            </div>
            <!-- Animal Type -->
            <div class="col-12 col-md-auto">
                <select id="inputAnimalType" class="d-inline form-control mt-3" name="animalType">
                    <option value="none" selected disabled hidden>Tipo de mascota</option>
                    <option value="dog">Perro</option>
                    <option value="cat">Gato</option>
                    <option value="other">Otro</option>
                </select>
            </div>
            <!-- Gender -->
            <div class="col-12 col-md-auto">
                <select id="inputGender" class="d-inline form-control mt-3" name="gender">
                    <option value="none" selected disabled hidden>Género</option>
                    <option value="male">Macho</option>
                    <option value="female">Hembra</option>
                </select>
            </div>
            <!-- Filter -->
            <div class="col-12 col-md-auto d-flex justify-content-center mt-3 mt-md-0">
                <button type="submit" class="text-white d-inline btn bg-orange mt-md-3 mb-3">Filtrar</button>
            </div>
        </form>
    </section>