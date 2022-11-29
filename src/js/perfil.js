
import Swal from 'sweetalert2';
(function () {

    const status = document.querySelector('#status');
    if (status) {

        status.addEventListener('input', seleccionarStatus);


        //En caso de que se actualize un perfil, se obtienen el status y nivel de acceso previamente definidos.
        let nivelValue = '';
        const nivelHidden = document.querySelector('#nivel-hidden');
        nivelValue = nivelHidden.value;

        let statusValue = '';
        statusValue = status.value;

        mostrarStatus();

        function seleccionarStatus(e) {

            statusValue = e.target.value;

            const contenedorPrevio = document.querySelector('.existe');
            if (contenedorPrevio) {
                contenedorPrevio.remove();
            }

            mostrarStatus();



        }

        function mostrarStatus() {

            if (statusValue === '1') {


                const contenedorNivel = document.createElement('DIV');
                contenedorNivel.classList.add('formulario__campo', 'existe');


                const labelNivel = document.createElement('LABEL');
                labelNivel.textContent = 'Nivel de Acceso';
                labelNivel.classList.add('formulario__label');

                const selectNivel = document.createElement('SELECT');
                selectNivel.name = "nivel";
                selectNivel.classList.add('formulario__input', 'formulario__input--select');

                selectNivel.innerHTML = `
                <option value=0 ${nivelValue == 0 ? 'selected' : ''}>Regular</option>
                <option value=1 ${nivelValue == 1 ? 'selected' : ''}>Privilegiado</option>`;

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
                    title: '¿Eliminar Registro Seleccionado?',
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


    //Filtrar perfiles de acuerdo al nombre especificado
    const buscador = document.querySelector('#buscador');

    if (buscador) {
        buscador.addEventListener('click', function (e) {
            e.preventDefault();
            const nombre = e.target.parentElement.querySelector('input').value;
            window.location = `?nombre=${nombre}`;
        })

    }




})();