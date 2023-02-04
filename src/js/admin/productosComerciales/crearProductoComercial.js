import { guardarCambioBD, mostrarAlerta } from "../../helpers";
import { domScriptingFormularioProducto } from "./domScriptingFormularioProducto";

(function () {
    const crearSubmit = document.querySelector('#submit-crear');

    if (crearSubmit) {


        domScriptingFormularioProducto();

        crearSubmit.addEventListener('click', function (e) {
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
            const url = "/api/producto-comercial/crear";

            const datos = new FormData();
            datos.append('nombre', nombre);
            datos.append('categoriaProducto_id', categoriaProducto_id);

            if (existeTipoAcero) datos.append('tiposaceros_id', tiposaceros_id);

            if (existeCostoBase) datos.append('costo', costoBase);

            await guardarCambioBD(datos, url, '/admin/producto-comercial');
        }
    }


})();