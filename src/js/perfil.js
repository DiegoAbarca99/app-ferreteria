
import Swal from 'sweetalert2';
(function () {

    const status = document.querySelector('#status');
    if (status) {

        status.addEventListener('input', seleccionarStatus);

        function seleccionarStatus(e) {

            const status = e.target.value;

            const contenedorPrevio = document.querySelector('.existe');
            if (contenedorPrevio) {
                contenedorPrevio.remove();
            }

            if (status === '1') {


                const contenedorNivel = document.createElement('DIV');
                contenedorNivel.classList.add('formulario__campo', 'existe');


                const labelNivel = document.createElement('LABEL');
                labelNivel.textContent = 'Nivel de Acceso';
                labelNivel.classList.add('formulario__label');

                const selectNivel = document.createElement('SELECT');
                selectNivel.name = "nivel";
                selectNivel.classList.add('formulario__input', 'formulario__input--select');

                selectNivel.innerHTML = `
                <option value=0>Regular</option>
                <option value=1>Privilegiado</option>`;

                contenedorNivel.appendChild(labelNivel);
                contenedorNivel.appendChild(selectNivel);


                const contenedorCampos = document.querySelector('#campos');
                contenedorCampos.appendChild(contenedorNivel);



            }

        }

    }



    //---------------------------Muestra alerta al momento de eliminar un usuario-------------------------

    const botonesEliminar = document.querySelectorAll('.eliminar-perfil');
    const eliminar = document.querySelector('#eliminar-perfil');
    if (eliminar || botonesEliminar.length) {

        if (eliminar) {
            eliminar.addEventListener('click', function (e) {
                e.preventDefault();

                let id = document.querySelector('#id');
                id = id.value;

                Swal.fire({
                    title: '¿Eliminar Perfil Seleccionado?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarPerfil(id);
                    }
                })

            });
        }


        if (botonesEliminar.length) {
            botonesEliminar.forEach(boton => boton.addEventListener('click', function (e) {
                e.preventDefault();

                let id = document.querySelector('#id');
                id = id.value;

                Swal.fire({
                    title: '¿Eliminar Perfil Seleccionado?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarPerfil(id);
                    }
                })

            }));
        }




        async function eliminarPerfil(id) {

            const datos = new FormData();
            datos.append('id', id);

            try {
                const url = "/perfiles/eliminar";

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.resultado) {
                    Swal.fire(resultado.mensaje, 'Eliminado', 'success').then(() => {
                        window.location.reload();
                    });

                }

            } catch (error) {
                Swal.fire('Error!', 'Ocurrió un error', 'error');
            }
        }
    }

})();