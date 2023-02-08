import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers/";
(function () {
    const eliminar = document.querySelector('#municipio-eliminar');

    if (eliminar) {
        eliminar.addEventListener('click', function (e) {
            e.preventDefault();

            const select = document.querySelector('#select-municipio');
            const id = select.value;


            Swal.fire({
                title: '¿Eliminar Municipio?',
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
            const url = "/api/municipios/eliminar";
            await eliminarElemento(id, url, '', 'Hay Cientes Vinculados a Este Municipio!', true);
        }

    }
})();