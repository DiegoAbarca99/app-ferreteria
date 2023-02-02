import Swal from 'sweetalert2';
import { eliminarElemento } from '../../helpers';

(function () {
    const inputHidden = document.querySelector('#eliminar-productosComerciales');

    if (inputHidden) {


        const btnEliminar = document.querySelectorAll('.eliminar-productoComercial');

        btnEliminar.forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();

                const id = e.target.parentElement.querySelector('#eliminar-productosComerciales').value;

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
        });


        async function prepararDatos(id) {
            const url = "/api/producto-comercial/eliminar";

            await eliminarElemento(id, url, '', 'Ha Ocurrido Un Error!', true);
        }


    }

})();