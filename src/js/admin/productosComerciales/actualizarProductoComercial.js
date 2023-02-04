import { guardarCambioBD } from "../../helpers";
import { domScriptingFormularioProducto } from "./domScriptingFormularioProducto";

(function () {
    const inputSubmitActualizar = document.querySelector('#submit-actualizar');
    if (inputSubmitActualizar) {



        //Valores previamente cargados
        // Costo Base
        const costoHidden = document.querySelector('#costo-hidden').value;
        // Tipo de Acero
        const aceroHidden = document.querySelector('#acero-hidden').value;



        domScriptingFormularioProducto(aceroHidden, costoHidden);


        inputSubmitActualizar.addEventListener('click', function (e) {
            e.preventDefault();
            validarInputs();

        });



        let existeTipoAcero = '';
        let existeCostoBase = '';
        let costoBase;
        let tiposaceros_id;

        function validarInputs() {

            const nombre = document.querySelector('#nombre').value;
            if (nombre == '') {
                mostrarAlerta('El nombre del producto es obligatorio', 'alerta--error', document.querySelector('.flex-izquierda'));
                return;
            }

            const categoriaProducto_id = document.querySelector('#categoriaProducto_id').value;
            if (categoriaProducto_id == '') {
                mostrarAlerta('Debe Seleccionar una Categoria', 'alerta--error', document.querySelector('.flex-izquierda'));
                return;
            }


            existeTipoAcero = document.querySelector('#tipo-acero');
            if (existeTipoAcero) {
                tiposaceros_id = document.querySelector('#tiposaceros_id').value;
                if (tiposaceros_id == '') {
                    mostrarAlerta('Debe Especificar el tipo de acero asociado al producto', 'alerta--error', document.querySelector('.flex-izquierda'));
                    return;
                }
            }

            existeCostoBase = document.querySelector('#costo-base');
            if (existeCostoBase) {
                costoBase = document.querySelector('#costo').value;
                if (costoBase == '') {
                    mostrarAlerta('Debe Especificar el costo base asociado al producto', 'alerta--error', document.querySelector('.flex-izquierda'));
                    return;
                }
            }

            prepararDatos(nombre, categoriaProducto_id);


        }

        async function prepararDatos(nombre, categoriaProducto_id) {
            const url = "/api/producto-comercial/actualizar";

            const datos = new FormData();

            const inputId = document.querySelector('#input-actualizar');
            const id = inputId.value;
            datos.append('id', id);

            datos.append('nombre', nombre);
            datos.append('categoriaProducto_id', categoriaProducto_id);

            if (existeTipoAcero) {
                datos.append('tiposaceros_id', tiposaceros_id);
                datos.append('eliminarCosto', true);
            }

            if (existeCostoBase) {
                datos.append('costo', costoBase);
                datos.append('eliminarAcero', true);
            }

            await guardarCambioBD(datos, url, '/admin/producto-comercial');
        }
    }
})();