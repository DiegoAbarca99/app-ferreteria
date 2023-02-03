import Swal from 'sweetalert2';
import { eliminarElemento } from '../../helpers';
(function () {
    const productoKilo = document.querySelector('.eliminar-productoKilo');

    if (productoKilo) {

        const botonEliminar = document.querySelectorAll('.eliminar-precioKilo');
        botonEliminar.forEach(boton => {
            boton.addEventListener('click', function (e) {
                e.preventDefault();
                const id = e.target.parentElement.querySelector('input').value;

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


            })
        });

        async function prepararDatos(id) {
            const url = "/api/producto-comercial/precios-kilos/eliminar";
            await eliminarElemento(id, url, '', 'Ha Ocurrido Un Error!', true);
        }

    }

})();