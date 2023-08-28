import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario, Toast, confirmacion } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";

const formulario = document.querySelector('form')
const btnGuardar = document.getElementById('btnGuardar');
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar');
const btnActivar = document.getElementById('btnActivar');
const btnDesactivar = document.getElementById('btnDesactivar');

btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'

let contador = 1;
const datatable = new Datatable('#tablaAsignaciones', {
    language: lenguaje,
    data: null,
    columns: [
        {
            title: 'NO',
            render: () => contador++
        },
        {
            title: 'USUARIO',
            data: 'usuario'
        },
        {
            title: 'ROL',
            data: 'rol',
        },
        {
            title: 'ESTADO',
            data: 'usu_estado',
        },
        {
            title: 'MODIFICAR PASSWORD',
            data: 'asignacion_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-usuario='${row["usuario"]}' data-rol='${row["rol"]}' >Modificar password</button>`
        },
        {
            title: 'MODIFICAR ROL',
            data: 'asignacion_id',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => `<button class="btn btn-warning btn-modificar-rol" data-id='${data}' data-usuario='${row["usuario"]}' data-rol='${row["rol"]}' data-bs-toggle="modal" data-bs-target="#modalModificarRol">Modificar rol</button>`
        },
        {
            title : 'ACTIVAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => row['usu_estado'].trim()==='P' || row['usu_estado'].trim()==='I'? `<button class="btn btn-success" data-id='${data}' >Activar</button>` :''
        },
        {
            title : 'DESACTIVAR',
            data: 'usu_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => row['usu_estado'].trim()==='A'? `<button class="btn btn-info" data-id='${data}' >DESACTIVAR</button>`: ''
        },
        
    ]
});

const buscar = async () => {
    let usuario = formulario.usuario.value;
    let rol = formulario.rol.value;
    const url = `/parcial_cornelio_IS_3/API/asignaciones/buscar`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if (data) {
            contador = 1;
            datatable.rows.add(data).draw();
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            })
        }

    } catch (error) {
        console.log(error);
    }
}

const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['asignacion_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        })
        return
    }

    const body = new FormData(formulario)
    body.delete('asignacion_id')
    const url = '/parcial_cornelio_IS_3/API/asignaciones/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                break;

            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id;
    const usuario = button.dataset.usuario;
    const rol = button.dataset.rol;

    const dataset = {
        id,
        usuario,
        rol
    };
    colocarDatos(dataset);
    const body = new FormData(formulario);
    body.append('asignacion_id', id);
    body.append('usuario', usuario);
    body.append('rol', rol);
};

const colocarDatos = (dataset) => {
    formulario.usuario.value = dataset.usuario;
    formulario.rol.value = dataset.rol;
    formulario.situacion_id.value = dataset.id;

    btnGuardar.disabled = true
    btnGuardar.parentElement.style.display = 'none'
    btnBuscar.disabled = true
    btnBuscar.parentElement.style.display = 'none'
    btnModificar.disabled = false
    btnModificar.parentElement.style.display = ''
    btnCancelar.disabled = false
    btnCancelar.parentElement.style.display = ''
}

const modificar = async () => {
    if (!validarFormulario(formulario)) {
        alert('Debe llenar todos los campos');
        return
    }

    const body = new FormData(formulario)
    const url = '/parcial_cornelio_IS_3/API/asignaciones/modificar';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success'
                buscar();
                cancelarAccion();
                break;

            case 0:
                icon = 'error'
                console.log(detalle)
                break;

            default:
                break;
        }

        Toast.fire({
            icon,
            text: mensaje
        })

    } catch (error) {
        console.log(error);
    }
}

const activar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    
    if (await confirmacion('warning', '¿Desea activar este usuario?')) {
        const body = new FormData();
        body.append('usu_id', id);
        const url = '/examen_parcial/API/permisos/activar';
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");
        const config = {
            method: 'POST',
            body
        };
        try {
            const respuesta = await fetch(url, config);    
            const data = await respuesta.json();
            const { codigo, mensaje } = data;

            let icon = 'info';
            switch (codigo) {
                case 1:
                    icon = 'success';
                    buscar();
                    break;
            
                case 0:
                    icon = 'error';
                    console.log(mensaje);
                    break;
            
                default:
                    break;
            }

            Toast.fire({
                icon,
                text: mensaje
            });

        } catch (error) {
            console.log(error);
        }
    }
};

const desactivar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;

    if (await confirmacion('warning', '¿Desea desactivar este usuario?')) {
        const body = new FormData();
        body.append('usu_id', id);
        const url = '/examen_parcial/API/permisos/desactivar';
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");
        const config = {
            method: 'POST',
            body
        };
        try {
            const respuesta = await fetch(url, config);    
            const data = await respuesta.json();
            const { codigo, mensaje } = data;

            let icon = 'info';
            switch (codigo) {
                case 1:
                    icon = 'success';
                    buscar();
                    break;
            
                case 0:
                    icon = 'error';
                    console.log(mensaje);
                    break;
            
                default:
                    break;
            }

            Toast.fire({
                icon,
                text: mensaje
            });

        } catch (error) {
            console.log(error);
        }
    }
};



const cancelarAccion = () => {
    btnGuardar.disabled = false
    btnGuardar.parentElement.style.display = ''
    btnBuscar.disabled = false
    btnBuscar.parentElement.style.display = ''
    btnModificar.disabled = true
    btnModificar.parentElement.style.display = 'none'
    btnCancelar.disabled = true
    btnCancelar.parentElement.style.display = 'none'
   
}



buscar();


formulario.addEventListener('submit', guardar)
btnBuscar.addEventListener('click', buscar)
btnCancelar.addEventListener('click', cancelarAccion)
btnModificar.addEventListener('click', modificar)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )
datatable.on('click','.btn-success', activar);
datatable.on('click','.btn-info', desactivar);