import { limpiarHtml } from "../../helpers/index";

//Inserta un input del costo Base o un Select con los tipos de acero, en función a la respuesta de los inputs Radio (si, no)
export function domScriptingFormularioProducto(aceroHidden, costoHidden) {
    const radio = document.querySelectorAll('input[name="respuesta"]');
    if (radio.length > 0) {

        const selectAcero = document.querySelector('#mostrar-select-acero');
        const inputCosto = document.querySelector('#mostrar-input-costo');
        let aceros = [];


        //Renderizar si hay valores preexistentes
        if (aceroHidden) {
            const radioAcero = document.querySelector('#si');
            radioAcero.checked = true;
            mostrarSelectAceros();

        } else if (costoHidden) {

            const radioCosto = document.querySelector('#no');
            radioCosto.checked = true;
            mostrarInputCosto();

        }

        radio.forEach(elemento => elemento.addEventListener('change', async function (e) {
            limpiarHtml(selectAcero);
            limpiarHtml(inputCosto);



            if (e.target.value === '1') {

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
            await obtenerAceros();


            let html = '';
            html += '<label for="tiposaceros_id" class="formulario__label" id="tipo-acero">Tipo de Acero</label>';
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


            let html = '';
            html += '<label class="formulario__label" for="costo" id="costo-base">Costo Base</label>';
            html += `<input  id="costo" class="formulario__input" type="number" min="0" step="any" placeholder="Ej. 5" value="${costoHidden ?? ''}"> `;

            inputCosto.innerHTML = html;
        }


    }
}