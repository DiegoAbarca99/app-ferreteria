import Swal from 'sweetalert2';

(function () {
    const inputHidden = document.querySelector('.eliminar-productoComercial');

    if (inputHidden) {

        let id = inputHidden.value;

        const btnEliminar = document.querySelectorAll('.btn-eliminar');

        if (btnEliminar.length) {
            btnEliminar.forEach(boton => {
                boton.addEventListener('click', function (e) {
                    e.preventDefault();

                    id = e.target.parentElement.querySelector('.eliminar-productoComercial').value;

                    Swal.fire({
                        title: '¿Eliminar Producto Seleccionado?',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                        icon: 'question'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            eliminarRegistro(id);
                        }
                    })
                });
            });
        } else {

            btnEliminar.addEventListener('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar Producto Seleccionado?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarRegistro(id);
                    }
                })
            });



        }

        async function eliminarRegistro(id) {

            //Conexión con ApiProductosComerciales para eliminar el registro seleccionado

            const datos = new FormData();
            datos.append('id', id);

            try {
                const url = "/api/producto-comercial/eliminar";

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo == 'exito') {
                    //Modal Confirmativo
                    Swal.fire(resultado.mensaje, 'Eliminado', 'success').then(() => {
                        window.location.replace('http://localhost:3000/admin/producto-comercial');
                    });
                }

            } catch (error) {
                //Modal Error
                Swal.fire('Error!', 'Ocurrió un error', 'error');
            }
        }

        // Filtra el contenido por categoria seleccionada en el select
        const filtro = document.querySelector('#select-producto');

        filtro.addEventListener('input', function (e) {
            const categoria = e.target.value;

            window.location = `?categoria=${categoria}`;
        });


    }
})();