import Swal from 'sweetalert2';
(function () {
    const productoKilo = document.querySelector('.eliminar-productoKilo');

    if (productoKilo) {

        const botonEliminar = document.querySelectorAll('.btn-eliminar');
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
                        eliminarRegistro(id);
                    }
                })


            })
        });


        async function eliminarRegistro(id) {

            //Conexión con ApiProductosComerciales para eliminar el registro seleccionado

            const datos = new FormData();
            datos.append('id', id);

            try {
                const url = "/api/producto-comercial/precios-kilos/eliminar";

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo == 'exito') {
                    //Modal Confirmativo
                    Swal.fire(resultado.mensaje, 'Eliminado', 'success').then(() => {
                        window.location.reload();
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