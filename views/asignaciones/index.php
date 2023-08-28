<h1 class="text-center">ASIGNACION DE ROLES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioPermiso">
        <input type="hidden" name="asignacion_id" id="asignacion_id">
        <div class="row mb-3">
                <div class="col">
                    <label for="usuario">SELECCIONAR USUARIO</label>
                    <select name="usuario" id="usuario" class="form-control">
                        <option value="">SELECCIONE...</option>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <option value="<?= $usuario['usu_id'] ?>"><?= $usuario['usu_nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col">
                    <label for="rol">ASIGNAR UN ROL</label>
                    <select name="rol" id="rol" class="form-control">
                        <option value="">SELECCIONE...</option>
                        <?php foreach ($roles as $rol) : ?>
                            <option value="<?= $rol['rol_id'] ?>"><?= $rol['rol_nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioPermiso" id="btnGuardar"  class="btn btn-primary w-100">Guardar</button>
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
<h1>ADMINISTRACION DE USUARIOS</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaAsignaciones" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/asignaciones/index.js') ?>"></script>