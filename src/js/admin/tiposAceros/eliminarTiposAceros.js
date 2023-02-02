import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers/index";

(function () {

    const botonesEliminar = document.querySelectorAll('.eliminar-tipoAcero');


    if (botonesEliminar.length > 0) {


        // Itera sobre el conjunto de botones de eliminar que comparten la tabla de tipos de aceros
        botonesEliminar.forEach(boton => boton.addEventListener('click', function (e) {
            e.preventDefault();

            //Se extrae el valor del inputHidden del registro que contiene el botón Seleccionado
            let id = e.target.parentElement.querySelector('.id');
            id = id.value;

            //Modal Interrogativo
            Swal.fire({
                title: '¿Eliminar Registro Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    //El registro Maestro que tiene la celda SLP que condiciona este valor para los demás, no puede eliminarse
                    if (id == 1) {
                        Swal.fire('No Es Posible Eliminar Este Registro', 'Error!', 'error');
                        return;
                    }

                    prepararDatos(id);

                }
            })

        }));

        async function prepararDatos(id) {
            const url = "/admin/acero/eliminar";
            await eliminarElemento(id, url, '', 'Ha Ocurrido Un Error!', true);
        }
    }
})();