import Swal from "sweetalert2";
import { guardarCambioBD } from "../../helpers/guardarCambioBD";
import { mostrarFormulario } from "../../helpers/mostrarFormulario";

(function () {
    const selectCategorias = document.querySelector('#select-categoria');
    if (selectCategorias) {

        let valorCategoriaFiltrada = '';
        let nombreCategoriaFiltrada = '';

        selectCategorias.addEventListener('input', function (e) {
            valorCategoriaFiltrada = e.target.value;
            nombreCategoriaFiltrada = document.querySelector(`option[value='${valorCategoriaFiltrada}']`).textContent;

        });


        const botonEditar = document.querySelector('#categoria-editar');
        botonEditar.addEventListener('click', function () {
            if (valorCategoriaFiltrada == '') {
                Swal.fire('No Hay Ninguna Categoria Seleccionada', 'Ha Ocurrido Un Error', 'error').then(() => {
                    window.location.reload();
                });

            } else {
                const modal = mostrarFormulario('Nombre', 'Editar Nombre', nombreCategoriaFiltrada);
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
                        } else {
                            prepararDatos(valor);

                        }
                    }

                });

                document.querySelector('.dashboard').appendChild(modal);

            }

        });


        async function prepararDatos(valor) {
            const url = "/api/categorias/actualizar/nombre";

            const datos = new FormData();
            datos.append('id', valorCategoriaFiltrada);
            datos.append('nombre', valor);

            await guardarCambioBD(datos, url);

        }

    }




})();