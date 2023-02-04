import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers/eliminarElemento";

(function () {
    const selectCategorias = document.querySelector('#select-categoria');
    if (selectCategorias) {

        let valorCategoriaFiltrada = '';

        selectCategorias.addEventListener('input', function (e) {
            valorCategoriaFiltrada = e.target.value;

        });

        const botonEliminar = document.querySelector('#categoria-eliminar');
        botonEliminar.addEventListener('click', () => {
            Swal.fire({
                title: '¿Eliminar la Categoría Seleccionada?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    prepararDatos();
                }
            })
        });

        async function prepararDatos() {
            const url = "/api/categorias/eliminar";
            await eliminarElemento(valorCategoriaFiltrada, url, '', 'Hay Productos Asociados a Esta Categoria!', true);

        }

    }
})();