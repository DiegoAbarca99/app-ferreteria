import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers/eliminarElemento";

(function () {
    const eliminarSucursal = document.querySelector('#sucursal-eliminar');

    if (eliminarSucursal) {
        eliminarSucursal.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar Sucursal?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = '/api/sucursales/eliminar';
                    const id = e.target.parentElement.querySelector('#sucursal_id').value;

                    eliminarElemento(id, url, '', 'Hay Perfiles Vinculados a Esta Sucursal', true);
                }
            })
        });

    }
})();