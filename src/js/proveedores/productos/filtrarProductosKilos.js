import { obtenerInformacionBD } from "../../helpers";
import { validarInputBuscador, mostrarClientesProductos } from "../helpers";

(function () {


    const contenedorProductosKilos = document.querySelector('#productos-kilos');
    const buscador = document.querySelector('#buscador-clientes-productos');
    if (contenedorProductosKilos && buscador) {



        prepararDatos();

        let productos = [];
        async function prepararDatos() {
            const url = '/api/productos/kilos'
            productos = await obtenerInformacionBD(url);

            mostrarClientesProductos(productos, contenedorProductosKilos, false);
        }

        const buscador = document.querySelector('#buscador-clientes-productos');
        buscador.addEventListener('submit', (e) => {
            e.preventDefault();
            validarInputBuscador(productos, contenedorProductosKilos, e, false);
        });

    }
})();