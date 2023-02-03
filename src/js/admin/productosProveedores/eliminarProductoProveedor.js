import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers";

(function () {
    const botonesEliminar = document.querySelectorAll('.btn-eliminarProductoProveedor');

    if (botonesEliminar.length > 0) {
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();
                const id = e.target.parentElement.querySelector('input').value;

                Swal.fire({
                    title: '¿Eliminar el Registro Seleccionado?',
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
        });

        async function prepararDatos(id) {
            const url = "/api/producto-proveedor/eliminar";
            await eliminarElemento(id, url, '', 'Ha Ocurrido Un Error!', true);
        }
    }


})();