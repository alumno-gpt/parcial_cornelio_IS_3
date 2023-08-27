<h1 class="text-center">FORMULARIO DE REGISTRO</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioUsuarios">
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
                <input type="password" name="usu_password" id="usu_password" class="form-control" autocomplete="false">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioUsuarios" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
            </div>
        </div>
    </form>
</div>

<script src="<?= asset('./build/js/usuarios/index.js') ?>"></script>