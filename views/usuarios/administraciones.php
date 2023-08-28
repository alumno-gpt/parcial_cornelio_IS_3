<h1 class="text-center">ADMINISTRACION DE USUARIOS</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-10 border bg-light p-3" id="formularioAdministracion">
        <input type="hidden" name="usu_id" id="usu_id">
        <div class="row mb-3">
            <div class="col">
                <label for="usu_nombre">Ingrese el nombre del usuario</label>
                <input type="text" name="usu_nombre" id="usu_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="usu_catalogo">Ingrese catalogo del usuario</label>
                <input type="text" name="usu_catalogo" id="usu_catalogo" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="usu_password">Ingrese contraseña para el usuario</label>
                <input type="password" name="usu_password" id="usu_password" class="form-control">
            </div>
        </div>
        <!-- <div class="col m-3">
            <label for="#">Seleccione rol del usuario</label>
            <select name="usu_estado" id="usu_estado" class="form-control">
                <option value="">Roles de usuario...</option>

            </select>
        </div> -->
        <div class="col m-3">
            <label for="#">Seleccione rol del usuario</label>
            <select name="usu_estado" id="usu_estado" class="form-control">
                <option>pendiente</option>
                <option>activo</option>
                <option>inactivo</option>

            </select>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioUsuarios" id="btnGuardar" data-saludo="hola" data-saludo2="hola2" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>
    </form>
</div>

<div class="row justify-content-center">
    <div class="card col-lg-10 border bg-light p-3">
        <h1 class="text-center">LISTADO DE USUARIOS</h1>
        <div class="col table-responsive">
            <table id="tablaAdministracion" class="table table-bordered table-hover">
            </table>
        </div>
    </div>
</div>

<script src="<?= asset('./build/js/usuarios/administraciones.js') ?>"></script>