<h1 class="text-center">ASIGNACION DE ROLES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioPermiso">
        <input type="hidden" name="asignacion_id" id="asignacion_id">
        <div class="row mb-3">
            <div class="col">
                <label for="usuario">SELECCIONAR USUARIO</label>
                <select name="usuario" id="usuario" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($usuarios as $usuario): ?>
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
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['rol_id'] ?>"><?= $rol['rol_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioPermiso" id="btnGuardar"
                    class="btn btn-primary w-100">Guardar</button>
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
<div class="modal fade" id="modalModificarRol" tabindex="-1" aria-labelledby="modalModificarRolLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarRolLabel">Modificar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Otros campos del formulario aquí -->

                <div class="mb-3">
                    <label for="nuevoRol" class="form-label">Nuevo Rol</label>
                    <select class="form-select" id="nuevoRol" name="nuevoRol">
                        <!-- Aquí cargarás las opciones de roles desde la base de datos -->
                        <?php foreach($roles as $role): ?>
                            <option value="<?php echo $role['rol_id']; ?>"><?php echo $role['rol_nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarRol">Guardar</button>
            </div>
        </div>
    </div>
</div>



<h1>ADMINISTRACION DE USUARIOS</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaAsignaciones" class="table table-bordered table-hover">
        </table>
    </div>
</div>

<script src="<?= asset('./build/js/asignaciones/index.js') ?>"></script>