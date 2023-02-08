import { obtenerInformacionBD } from "../../helpers";
import { validarInputBuscador,mostrarClientesProductos } from "../helpers/";

(function () {

    const selectOpcion = document.querySelector('#select-opcion');
    const contenedorClientes = document.querySelector('#clientes');

    if (selectOpcion && contenedorClientes) {
        let clientes = [];

        selectOpcion.addEventListener('change', (e) => {
            const id = e.target.value;
            const url = `/api/clientes?id=${id}`;
            prepararDatos(url);

        });

        async function prepararDatos(url) {
            clientes = await obtenerInformacionBD(url);
            mostrarClientesProductos(clientes, contenedorClientes, true);
        }

        const buscador = document.querySelector('#buscador-clientes-productos');
        buscador.addEventListener('submit', (e) => {
            e.preventDefault();
            validarInputBuscador(clientes, contenedorClientes, e, true);
        });

    }
})();