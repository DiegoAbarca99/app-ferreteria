import Swal from "sweetalert2";
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

                    eliminarMunicipio(id);
                }
            })
        });

        async function eliminarMunicipio(id) {
            if (!id) {
                Swal.fire('No Hay Ningùn Municipio Seleccionado', 'Ha Ocurrido Un Error', 'error');
                return;
            }


            try {

                const url = "/api/municipios/eliminar";
                const datos = new FormData();
                datos.append('id', id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                })

                const resultado = await respuesta.json();


                if (resultado.tipo == 'exito') {


                    Swal.fire('Eliminado!', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    });


                }
            } catch (error) {
                console.error(error);
                Swal.fire('Hay Registros Asociados a Este Municipio', 'Ha ocurrido un error', 'error');
            }
        }

    }
})();