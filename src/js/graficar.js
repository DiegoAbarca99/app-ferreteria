import Swal from 'sweetalert2';

(function () {
    const btnBuscar = document.querySelector('#buscar-pedidos');

    if (btnBuscar) {
        const inputFecha = document.querySelector('#mes');
        const inputPagado = document.querySelectorAll('input[name="pagado"]')
        let fecha;
        let pagado;


        inputFecha.addEventListener('input', (e) => {
            fecha = e.target.value;


        });


        inputPagado.forEach(input => {
            input.addEventListener('input', function (e) {
                pagado = e.target.value;
            })
        });

        btnBuscar.addEventListener('click', (e) => {
            e.preventDefault();
            if (!fecha || !pagado) {
                Swal.fire('Debe llenar todos los campos!', '', 'error');
            } else {
                obtenerPedidos();
            }
        })


        async function obtenerPedidos() {
            try {
                console.log(fecha, pagado)
                const url = `/api/pedidos/graficar?fecha=${fecha}&pagado=${pagado}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                if (resultado.length == 0) {
                    Swal.fire('No Hay Pedidos Existentes En Ese Mes!', 'Error', 'error');
                } else {


                    generarGrafica(resultado);

                }


            } catch (error) {
                console.log(error);
                Swal.fire('Ha ocurrido un error!', 'Error', 'error');

            }



        }



        function generarGrafica(resultado) {

            let cantidadNeta = 0;

            resultado.forEach(cantidad => cantidadNeta += cantidad);

            const grafico = document.querySelector('#grafico');
            limpiarHtml(grafico);

            const headingGrafico = document.createElement('H4');
            headingGrafico.textContent = pagado == 1 ? 'Ganancias' : 'Deudas';

            const total = document.createElement('H4');
            if (pagado == 1) {
                total.textContent = `Ganancias:${cantidadNeta}`;
                total.style.color = '#008f39';
            } else {
                total.textContent = `Deudas:${cantidadNeta}`;
                total.style.color = '#FF0000';
            }

            const canvas = document.createElement('CANVAS');



            const ctx = canvas.getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
                    datasets: [{
                        label: pagado == 1 ? 'Ganancias' : 'Deudas',
                        data: resultado.map(total => total),
                        backgroundColor: [
                            pagado == 1 ? '#008f39' : '#FF0000',
                        ],

                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            grafico.appendChild(headingGrafico);
            grafico.appendChild(canvas);
            grafico.appendChild(total);



        }

        function limpiarHtml(contenedor) {
            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }

    }
})();