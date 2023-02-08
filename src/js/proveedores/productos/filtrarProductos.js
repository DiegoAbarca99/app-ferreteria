import { obtenerInformacionBD } from "../../helpers";
import { validarInputBuscador,mostrarClientesProductos } from "../helpers";

(function () {

    const selectOpcion = document.querySelector('#select-opcion');
    const contenedorProductos = document.querySelector('#productos');

    if (selectOpcion && contenedorProductos) {
        let productos = [];


        selectOpcion.addEventListener('change', (e) => {
            const id = e.target.value;
            const url = `/api/productos?id=${id}`
            prepararDatos(url);

        });

        let productosFormateados = [];
        async function prepararDatos(url) {
            productos = await obtenerInformacionBD(url);

            productosFormateados = productos.map(elemento => {
                return {
                    nombre: elemento.categoria.nombre + ' ' + elemento.nombre,
                    precio: elemento.precio
                }
            });


            mostrarClientesProductos(productosFormateados, contenedorProductos, false);
        }

        const buscador = document.querySelector('#buscador-clientes-productos');
        buscador.addEventListener('submit', (e) => {
            e.preventDefault();
            validarInputBuscador(productosFormateados, contenedorProductos, e, false);
        });

    }
})();