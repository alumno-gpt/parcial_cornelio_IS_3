import { Dropdown } from "bootstrap";
import Chart from "chart.js/auto";
import { Toast } from "../funciones";

const canvas = document.getElementById('chartEstado');
const btnActualizar = document.getElementById('btnActualizar');
const context = canvas.getContext('2d');

const chartEstado = new Chart(context, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Usuarios por estado',
                data: [],
                backgroundColor: []
            },
        ]
    },
    options: {
        indexAxis: 'y'
    }
});

const getEstadisticas = async () => {
    const url = `/parcial_cornelio_IS_3/API/graficos/data?tipo=1`;
    const config = {
        method: 'GET'
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        chartEstado.data.labels = [];
        chartEstado.data.datasets[0].data = [];
        chartEstado.data.datasets[0].backgroundColor = [];

        if (data) {
            data.forEach(registro => {
                chartEstado.data.labels.push(registro.estado);
                chartEstado.data.datasets[0].data.push(registro.cantidad_usuarios);
                chartEstado.data.datasets[0].backgroundColor.push(getRandomColor());
            });
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }
        
        chartEstado.update();
       
    } catch (error) {
        console.log(error);
    }
};

const getRandomColor = () => {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

    const rgbColor = `rgba(${r},${g},${b},0.5)`;
    return rgbColor;
}

getEstadisticas();

btnActualizar.addEventListener('click', getEstadisticas);
