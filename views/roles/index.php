<h1 class="text-center">FORMULARIO DE ROLES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioRoles">
        <input type="hidden" name="rol_id" id="rol_id">
        <div class="row mb-3">
            <div class="col">
                <label for="rol_nombre">Ingrese el nombre del rol</label>
                <input type="text" name="rol_nombre" id="rol_nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
        <h1 class="text-center">LISTADO DE ROLES</h1>
        <div class="col table-responsive">
            <table id="tablaRoles" class="table table-bordered table-hover">
            </table>
        </div>
    </div>
</div>

<script src="<?= asset('./build/js/roles/index.js') ?>"></script>