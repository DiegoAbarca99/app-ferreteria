
import { mostrarFormulario, mostrarAlerta, guardarCambioBD } from "../../helpers/index";

(function () {

    const abonos = document.querySelectorAll('.table--abono');
    if (abonos.length > 0) {

        abonos.forEach(abono => {
            abono.addEventListener('click', function (e) {
                const abono = e.target.textContent;
                const id = e.target.dataset.abono;

                const modal = mostrarFormulario('Abono', 'Editar Abono', abono,true);
                const body = document.querySelector('body');

                modal.addEventListener('click', function (e) {
                    e.preventDefault();

                    //--------------Aplicando delegation para determinar cuando se dió click en cerrar
                    if (e.target.classList.contains('cerrar-modal')) {

                        body.classList.remove('pausar');
                        const formulario = document.querySelector('.formulario-animar');
                        formulario.classList.add('cerrar');


                        setTimeout(() => {
                            modal.remove();
                        }, 500);
                    }


                    //--------------Aplicando delegation para determinar cuando se dió click en el input de tipo submit
                    if (e.target.classList.contains('submit-nuevo-valor')) {

                        body.classList.remove('pausar');

                        const valor = document.querySelector('#valor').value.trim();

                        if (valor === '') {
                            //Mostrar alerta de error
                            mostrarAlerta('El Valor es obligatorio', 'alerta--error',
                                document.querySelector('.formulario-animar legend'));
                            return;
                        }

                        prepararDatos(valor, id);

                    }

                });


                document.querySelector('.dashboard').appendChild(modal);
            });
        });

        async function prepararDatos(valor, id) {
            const url = "/api/pedidos/abono";

            const datos = new FormData();
            datos.append('abono', valor);
            datos.append('id', id);
            datos.append('fromProveedor', true);

            await guardarCambioBD(datos, url);
        }

    }

})();