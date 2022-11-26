import Swal from 'sweetalert2';
(function () {

    //-------------------------Formulario crear y actualizar-----------------------------------------------------------
    const radio = document.querySelectorAll('input[name="respuesta"]');
    if (radio.length) {

        //Enviar Petición POST para crear al servidor
        const inputSubmit = document.querySelector('#submit-crear');
        if (inputSubmit) {

            inputSubmit.addEventListener('click', function (e) {
                e.preventDefault();
                enviarPost();
            });
        }


        //Enviar Petición POST para actualizar al servidor
        const inputSubmitActualizar = document.querySelector('#submit-actualizar');
        if (inputSubmitActualizar) {
            inputSubmitActualizar.addEventListener('click', function (e) {
                e.preventDefault();
                enviarPost(true);
            });
        }


        //Inserta un input del costo Base o un Select con los tipos de acero, en función a la respuesta de los inputs Radio (si, no)
        const selectAcero = document.querySelector('#mostrar-select-acero');
        const inputCosto = document.querySelector('#mostrar-input-costo');

        //Valors previamente cargados (actualizar)
        // Costo Base
        const inputCostoHidden = document.querySelector('#costo-hidden');
        let costoHidden;
        if (inputCostoHidden) {
            costoHidden = inputCostoHidden.value;
        }
        let eliminarCosto;

        // Tipo de Acero
        const inputAceroHidden = document.querySelector('#acero-hidden');
        let aceroHidden;
        if (inputAceroHidden) {
            aceroHidden = inputAceroHidden.value;
        }
        let eliminarAcero;


        let aceros = [];

        let acero;
        let costoBase;
        let html = '';

        if (aceroHidden) {

            const radioAcero=document.querySelector('#si');
            radioAcero.checked=true;
            mostrarSelectAceros();
           
        } else if(costoHidden){

            const radioCosto=document.querySelector('#no');
            radioCosto.checked=true;
            mostrarInputCosto();
            

        }




        radio.forEach(elemento => elemento.addEventListener('change', async function (e) {
            limpiarHtmlSelect();
            limpiarHtmlInput();
            if (e.target.value == '1') {

                mostrarSelectAceros();

            } else {
                mostrarInputCosto();


            }

        }));

        async function obtenerAceros() {
            const url = '/api/tipos-acero';

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            aceros = resultado;

        }

        async function mostrarSelectAceros() {
            //Obtiene los tipos de acero de la Base de datos
            await obtenerAceros();

            acero = true;
            costoBase = false;
            if (costoHidden) {
                eliminarCosto = true;
            }

            html = '';
            html += '<label for="tiposaceros_id" class="formulario__label">Tipo de Acero</label>';
            html += ' <select class="formulario__input formulario__input--select" name="tiposaceros_id" id="tiposaceros_id">';
            html += '  <option value="" selected>--Seleccione una Opción--</option>';
            aceros.forEach(acero => {
                html += `<option value="${acero.id}" ${acero.id == aceroHidden ? 'selected' : ''}> ${acero.nombre} </option>`;
            });
            html += ' </select>';
            html += ' <a class="formulario__enlace" href="/admin/acero">Gestionar Tipos de Acero</a>'


            selectAcero.innerHTML = html;

        }

        function mostrarInputCosto() {
            acero = false;
            costoBase = true;
            if (aceroHidden) {
                eliminarAcero = true;
            }

            html = '';
            html += '<label class="formulario__label" for="costo">Costo Base</label>';
            html += `<input  id="costo" class="formulario__input" type="number" min="0" step="any" placeholder="Ej. 5" value="${costoHidden ?? ''}"> `;

            inputCosto.innerHTML = html;
        }

        async function enviarPost(is_actualizar = false) {

            let post = true;

            const nombre = document.querySelector('#nombre').value;
            if (nombre == '') {
                post = false;
                mostrarAlerta('El nombre del producto es obligatorio', 'alerta--error', document.querySelector('.formulario__fieldset'), 1);
            }

            const categoriaProducto_id = document.querySelector('#categoriaProducto_id').value;
            if (categoriaProducto_id == '') {
                post = false
                mostrarAlerta('Debe Seleccionar una Categoria', 'alerta--error', document.querySelector('.formulario__fieldset'), 2);
            }

            let tiposaceros_id;
            if (acero) {
                tiposaceros_id = document.querySelector('#tiposaceros_id').value;
                if (tiposaceros_id == '') {
                    post = false;
                    mostrarAlerta('Debe Especificar el tipo de acero asociado al producto', 'alerta--error', document.querySelector('.formulario__fieldset'), 3);
                }
            }

            let costo;
            if (costoBase) {
                costo = document.querySelector('#costo').value;
                if (costo == '') {
                    post = false;
                    mostrarAlerta('Debe Especificar el costo base asociado al producto', 'alerta--error', document.querySelector('.formulario__fieldset'), 4);
                }
            }

            if (post) {


                try {

                    let url;
                    if (is_actualizar) {
                        url = "/api/producto-comercial/actualizar";
                    } else {
                        url = "/api/producto-comercial/crear";
                    }
                    const datos = new FormData();

                    if (is_actualizar) {
                        const inputId = document.querySelector('#input-actualizar');
                        const id = inputId.value;
                        datos.append('id', id);
                    }

                    datos.append('nombre', nombre);
                    datos.append('categoriaProducto_id', categoriaProducto_id);


                    if (acero) {
                        if (eliminarCosto) {
                            datos.append('eliminarCosto', eliminarCosto);
                        }
                        datos.append('tiposaceros_id', tiposaceros_id);
                    }

                    if (costoBase) {
                        if (eliminarAcero) {
                            datos.append('eliminarAcero', eliminarAcero);
                        }
                        datos.append('costo', costo);
                    }

                    console.log([...datos])
                    const respuesta = await fetch(url, {
                        method: 'POST',
                        body: datos
                    });

                    const resultado = await respuesta.json();

                    if (resultado.tipo == 'error') {
                        Swal.fire(resultado.mensaje, 'Ocurrió un error', 'error').then(() => {
                            window.location.reload();
                        });
                    }


                    if (resultado.tipo == 'exito') {
                        Swal.fire(resultado.mensaje, 'Exito', 'success').then(() => {
                            window.location.replace('http://localhost:3000/admin/producto-comercial');
                        });
                    }




                } catch (error) {
                    console.error(error)
                    Swal.fire('Error', 'Ocurrió un error', 'error');
                }
            }




        }

        function mostrarAlerta(mensaje, tipo, referencia, numero) {

            const alerta = document.createElement('DIV');
            alerta.classList.add('alerta', tipo);
            alerta.textContent = mensaje;

            if (numero == 1) {

                const alertaPrevia = document.querySelector(`.n-${numero}`);
                if (alertaPrevia) alertaPrevia.remove();

                alerta.classList.add(`n-${numero}`);
            }

            if (numero == 2) {

                const alertaPrevia = document.querySelector(`.n-${numero}`);
                if (alertaPrevia) alertaPrevia.remove();

                alerta.classList.add(`n-${numero}`);
            }

            if (numero == 3) {

                const alertaPrevia = document.querySelector(`.n-${numero}`);
                if (alertaPrevia) alertaPrevia.remove();

                alerta.classList.add(`n-${numero}`);
            }

            if (numero == 4) {

                const alertaPrevia = document.querySelector(`.n-${numero}`);
                if (alertaPrevia) alertaPrevia.remove();

                alerta.classList.add(`n-${numero}`);
            }

            setTimeout(() => {
                alerta.remove();
            }, 5000);


            referencia.parentElement.insertBefore(alerta, referencia);


        }

        function limpiarHtmlSelect() {

            while (selectAcero.firstChild) {
                selectAcero.removeChild(selectAcero.firstChild);
            }
        }

        function limpiarHtmlInput() {

            while (inputCosto.firstChild) {
                inputCosto.removeChild(inputCosto.firstChild);
            }
        }
    }
})();