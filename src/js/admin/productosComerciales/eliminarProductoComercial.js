import Swal from 'sweetalert2';
import { eliminarElemento } from '../../helpers';

(function () {
    const inputHidden = document.querySelector('#eliminar-productoComercial');

    if (inputHidden) {

        const btnEliminar = document.querySelector('.btn-eliminar');


        btnEliminar.addEventListener('click', (e) => {
            e.preventDefault();

            const id = inputHidden.value;

            Swal.fire({
                title: '¿Eliminar Producto Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    prepararDatos(id);
                }
            })

        });


        async function prepararDatos(id) {
            const url = "/api/producto-comercial/eliminar";

            await eliminarElemento(id, url, '/admin/producto-comercial', 'Ha Ocurrido Un Error!');
        }



    }



})();