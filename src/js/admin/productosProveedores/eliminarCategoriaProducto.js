import Swal from "sweetalert2";
import { eliminarElemento } from "../../helpers";

(function () {
    const btnEliminar = document.querySelector('#categoria-producto-eliminar');
    if (btnEliminar) {

        btnEliminar.addEventListener('click', () => {

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
            const inputCategoria = document.querySelector('#categoriaProductosProveedores_id');
            const id = inputCategoria.value;
            const url = "/api/producto-proveedor/eliminar/categoria";

            await eliminarElemento(id, url, '', 'Hay Productos Asociados a Esta Categoria', true);
        }

    }
})();