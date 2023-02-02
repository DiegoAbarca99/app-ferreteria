import Swal from "sweetalert2";
import { eliminarElemento } from './../../helpers/index';

(function () {
    const categoriaEliminar = document.querySelector('#categoria-acero-eliminar');
    if (categoriaEliminar) {
        categoriaEliminar.addEventListener('click', function () {
            Swal.fire({
                title: '¿Eliminar la Categoria Seleccionada?',
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

            const inputCategoria = document.querySelector('#categoriaacero_id');
            const id = inputCategoria.value;
            const url = "/api/tipos-acero/eliminar/categoria";

            await eliminarElemento(id, url, '', 'Hay Registro Asociados a Esta Categoria', true);
        }

    }
})();