import Swal from "sweetalert2";
(function () {
    const botonEliminar = document.querySelector('#eliminar-cliente');

    if (botonEliminar) {
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
                    eliminarCliente(e.target.value);
                }
            })
        });
        async function eliminarCliente(id) {

            try {
                const url = '/proveedor/clientes/eliminar';
                const datos = new FormData();
                datos.append('id', id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.resultado) {
                    Swal.fire('Eliminado!', resultado.mensaje, 'success').then(() => {
                        window.location.href = '/proveedor/clientes';
                    });
                } else {
                    Swal.fire('Ha ocurrido un error', 'Error', 'error');
                }

            } catch (error) {
                console.error(error);
                Swal.fire('Ha ocurrido un error', 'Error', 'error');
            }


        }
    }


})();