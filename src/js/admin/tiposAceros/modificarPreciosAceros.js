
import { mostrarAlerta, mostrarFormulario, editarElemento } from '../../helpers/index';

(function () {

    // Determinar el script actual para operar sobre los elementos que están presentes
    const botonesEliminar = document.querySelectorAll('.eliminar-tipoAcero');

    if (botonesEliminar.length > 0) {

        //Modificar los precios SLP, prolamsa y arcaMetal al dar click a la celda
        let registroActualizar;
        const url = '/api/tipos-acero/actualizar/precios';

        const registros = document.querySelectorAll('.id');
        registros.forEach(registro => {

            //El primer registro es el único en que puede alterarse SLP
            if (registro.value == 1) {

                const registroResaltar = registro.parentElement.parentElement.parentElement.querySelector('.table__td--slp');
                registroResaltar.classList.add('table__td--slp-naranja');


                registroResaltar.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);

                    const modal = mostrarFormulario('SLP', 'Editar SLP', valor);

                    seleccionarOpcionesFormulario(modal, 'slp');

                });
            } else {

                //Para los demás registro se modifica ArcoMetal y Prolamsa

                const registroProlamsa = registro.parentElement.parentElement.parentElement.querySelector('.table__td--prolamsa');
                const registroArcoMetal = registro.parentElement.parentElement.parentElement.querySelector('.table__td--arcoMetal');

                registroProlamsa.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);

                    const modal = mostrarFormulario('Prolamsa', 'Editar Prolamsa', valor);
                    seleccionarOpcionesFormulario(modal, 'prolamsa');
                });

                registroArcoMetal.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);
                    const modal = mostrarFormulario('ArcoMetal', 'Editar ArcoMetal', valor);
                    seleccionarOpcionesFormulario(modal, 'arcoMetal');
                });


            }

        });


        function seleccionarOpcionesFormulario(modal, tipo) {
            modal.addEventListener('click', function (e) {
                e.preventDefault();

                const body = document.querySelector('body');

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
                            document.querySelector('.formulario legend'));
                        return;
                    }


                    prepararDatos(valor, tipo);

                }

            });
            document.querySelector('.dashboard').appendChild(modal);
        }

        async function prepararDatos(valor, tipo) {
            const datos = new FormData();

            datos.append('id', registroActualizar.value);
            datos.append(tipo, valor);

            await editarElemento(datos, url);

        }

    }


})();
