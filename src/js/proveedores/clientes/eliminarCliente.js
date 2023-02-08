import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers/eliminarElemento";
(function () {
    const botonEliminar = document.querySelector('#eliminar-cliente');

    if (botonEliminar) {

        const id = botonEliminar.value;
        botonEliminar.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar Cliente?',
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
            const url = '/proveedor/clientes/eliminar';
            eliminarElemento(id, url, '', 'Este Cliente Posee Pedidos Asociados!', true);
        }

    }


})();