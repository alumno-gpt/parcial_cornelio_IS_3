import { Dropdown } from "bootstrap";
import Chart from "chart.js/auto";
import { Toast } from "../funciones";

const canvas = document.getElementById('chartRoles');
const btnActualizar = document.getElementById('btnActualizar');
const context = canvas.getContext('2d');

const chartRoles = new Chart(context, {
    type: 'pie',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Usuarios por roles',
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
    const url = `/parcial_cornelio_IS_3/API/graficos/data?tipo=2`;
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log("data", data)

        chartRoles.data.labels = [];
        chartRoles.data.datasets[0].data = [];
        chartRoles.data.datasets[0].backgroundColor = [];

        if (data) {
            data.forEach(registro => {
                chartRoles.data.labels.push(registro.rol);
                chartRoles.data.datasets[0].data.push(registro.cantidad_usuarios);
                chartRoles.data.datasets[0].backgroundColor.push(getRandomColor());
            });
        } else {
            Toast.fire({
                title: 'No se encontraron registros',
                icon: 'info'
            });
        }

        chartRoles.update();

    } catch (error) {
        console.log(error);
    }
}

const getRandomColor = () => {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);

    const rgbColor = `rgba(${r},${g},${b},0.5)`;
    return rgbColor;
}

getEstadisticas();

btnActualizar.addEventListener('click', getEstadisticas);
