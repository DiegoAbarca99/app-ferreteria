import { limpiarHtml } from "../../helpers";
import { mostrarClientesProductos } from "./mostrarClientesProductos";

export function validarInputBuscador(arregloInformacion, contenedorInformacion, e, editar = false) {


    limpiarHtml(contenedorInformacion);

    if (arregloInformacion.length == 0) {

        const contenedorMensaje = document.createElement('DIV');

        const mensajeHeading = document.createElement('P');
        mensajeHeading.textContent = 'Debe seleccionar una opción primero.';

        contenedorMensaje.appendChild(mensajeHeading);
        contenedorInformacion.appendChild(contenedorMensaje);
    } else {

        const busqueda = e.target.querySelector('input[type="text"]').value;
        let informacionFiltrada = [];

        if (busqueda.trim().length > 3) {

            const expresion = RegExp(busqueda, 'i');
            informacionFiltrada = arregloInformacion.filter(informacion => {

                if (informacion.nombre.toLowerCase().search(expresion) != -1) {
                    return informacion;
                }

            });

            if (informacionFiltrada.length > 0) {
                mostrarClientesProductos(informacionFiltrada, contenedorInformacion, editar);
            } else {
                const contenedorMensaje = document.createElement('DIV');

                const mensajeHeading = document.createElement('P');
                mensajeHeading.textContent = 'No hay ningún resultado asociado.';

                contenedorMensaje.appendChild(mensajeHeading);
                contenedorInformacion.appendChild(contenedorMensaje);
            }

        } else {
            const contenedorMensaje = document.createElement('DIV');

            const mensajeHeading = document.createElement('P');
            mensajeHeading.textContent = 'Debe de ingresar minimo 4 carécteres.';

            contenedorMensaje.appendChild(mensajeHeading);
            contenedorInformacion.appendChild(contenedorMensaje);
        }


    }


}