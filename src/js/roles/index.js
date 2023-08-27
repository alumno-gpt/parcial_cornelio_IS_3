import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import Datatable from "datatables.net-bs5";
import { lenguaje  } from "../lenguaje";
import { validarFormulario, Toast, confirmacion } from "../funciones";

const formulario = document.querySelector('form')
const btnBuscar = document.getElementById('btnBuscar');
const btnModificar = document.getElementById('btnModificar');
const btnGuardar = document.getElementById('btnGuardar');
const btnCancelar = document.getElementById('btnCancelar');


btnModificar.disabled = true
btnModificar.parentElement.style.display = 'none'
btnCancelar.disabled = true
btnCancelar.parentElement.style.display = 'none'


let contador = 1;
const datatable = new Datatable('#tablaRoles', {
    language : lenguaje,
    data : null,
    columns: [
        {
            title : 'NO',
            render : () => contador ++
            
        },
        {
            title : 'NOMBRE',
            data: 'rol_nombre'
        },
        {
            title : 'MODIFICAR',
            data: 'rol_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-warning" data-id='${data}' data-nombre='${row["rol_nombre"]}'>Modificar</button>`
        },
        {
            title : 'ELIMINAR',
            data: 'rol_id',
            searchable : false,
            orderable : false,
            render : (data, type, row, meta) => `<button class="btn btn-danger" data-id='${data}' >Eliminar</button>`
        },
        
    ]
})

const buscar = async () => {

    let rol_nombre = formulario.rol_nombre.value;
    const url = `/parcial_cornelio_IS_3/API/roles/buscar`;
    
    const config = {
        method : 'GET'
    }

    try {
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();

        console.log(data);
        datatable.clear().draw()
        if(data){
            contador = 1;
            datatable.rows.add(data).draw();
            
        }else{
            Toast.fire({
                title : 'No se encontraron registros',
                icon : 'info'
            })
        }
       
    } catch (error) {
        console.log(error);
    }
}
const guardar = async (evento) => {
    evento.preventDefault();
    if (!validarFormulario(formulario, ['rol_id'])) {
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return;
    }

    const body = new FormData(formulario);
    body.delete('rol_id');
    const url = '/parcial_cornelio_IS_3/API/roles/guardar';
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const { codigo, mensaje, detalle } = data;
        let icon = 'info';
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success', 
                        'mensaje';
                buscar();
                break;

            case 0:
                icon = 'error';
                console.log(detalle);
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




const traeDatos = (e) => {
    const button = e.target;
    const id = button.dataset.id
    const nombre = button.dataset.nombre

    const dataset = {
        id, 
        nombre, 
};

colocarDatos(dataset);

const body = new FormData(formulario);
body.append('rol_id', id );
body.append('rol_nombre', nombre);


};

const colocarDatos = (dataset) => {
    formulario.rol_nombre.value = dataset.nombre;
    formulario.rol_id.value = dataset.id;
    
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
    if(!validarFormulario(formulario)){
        Toast.fire({
            icon: 'info',
            text: 'Debe llenar todos los datos'
        });
        return 
    }

    const body = new FormData(formulario)
    const url = '/parcial_cornelio_IS_3/API/roles/modificar';
    const config = {
        method : 'POST',
        body
    }

    try {
      
        const respuesta = await fetch(url, config)
        const data = await respuesta.json();
        
        const {codigo, mensaje,detalle} = data;
        let icon = 'success'
        switch (codigo) {
            case 1:
                formulario.reset();
                icon = 'success';
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

const eliminar = async (e) => {
    const button = e.target;
    const id = button.dataset.id;
    // console.log(id);
    if (await confirmacion('warning', 'Desea elminar este registro?')) {
        const body = new FormData()
        body.append('rol_id', id)
        const url = '/parcial_cornelio_IS_3/API/roles/eliminar';
        const headers = new Headers();
        headers.append("X-Requested-With","fetch");
        const config = {
            method: 'POST',
            body
        }
        try {
            const respuesta = await fetch(url, config)
            const data = await respuesta.json();
            // console.log(data);
            // return;


            const { codigo, mensaje, detalle } = data;
            let icon = 'info'
            switch (codigo) {
                case 1:
                    // formulario.reset();
                    icon = 'success'
                    buscar();
                    // cancelarAccion();
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

}





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
btnModificar.addEventListener('click', modificar)
btnCancelar.addEventListener('click', cancelarAccion)
datatable.on('click','.btn-warning', traeDatos )
datatable.on('click','.btn-danger', eliminar )