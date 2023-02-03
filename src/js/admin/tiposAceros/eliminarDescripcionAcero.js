import Swal from 'sweetalert2';
import { eliminarElemento } from './../../helpers/index';
(function () {
    const descripcionEliminar = document.querySelector('#descripcion-acero-eliminar');

    if (descripcionEliminar) {

        descripcionEliminar.addEventListener('click', function () {
            Swal.fire({
                title: '¿Eliminar la Descripción Seleccionada?',
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

            const inputDescripcion = document.querySelector('#descripcionacero_id');
            const id = inputDescripcion.value;
            const url = "/api/tipos-acero/eliminar/descripcion";

            await eliminarElemento(id, url, '', 'Hay Registro Asociados a Esta Descripción', true);
        }


    }
})();