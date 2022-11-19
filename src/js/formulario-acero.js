import Swal from 'sweetalert2';
(function () {

    const categoria = document.querySelector('#categoria-acero');
    const descripcion = document.querySelector('#descripcion-acero');
    const categoriaEliminar = document.querySelector('#categoria-acero-eliminar');
    const descripcionEliminar = document.querySelector('#descripcion-acero-eliminar');

    if (categoria && descripcion && categoriaEliminar && descripcionEliminar) {

        categoria.addEventListener('click', function () {
            mostrarFormulario()
        });
        descripcion.addEventListener('click', function () {
            mostrarFormulario(false);
        });

        categoriaEliminar.addEventListener('click', function () {
            confirmarEliminar();
        });

        descripcionEliminar.addEventListener('click', function () {
            confirmarEliminar(false);
        });

        function mostrarFormulario(is_categoria = true) {

            const inicio = document.querySelector('#cerrar-menu');
            if (inicio) {
                inicio.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            const body = document.querySelector('body');
            body.classList.add('pausar');


            const modal = document.createElement('DIV');
            modal.classList.add('modal');


            const formulario = `
            <form class="formulario formulario--tipo-acero">

                <legend>${is_categoria ? 'Agregar Categoria' : 'Agregar Descripción'}</legend>
                <div class="formulario__campo"
                    <label class="formulario__label" for="valor">${is_categoria ? 'Categoria' : 'Descripción'}</label>
                    <input class="formulario__input" type="text" name="valor" id="valor">
                </div>
                 <div class="opciones">
                    <input type="submit" class="submit-nuevo-valor" value="Agregar">
                    <button class="cerrar-modal" type="button">Cancelar </button>
                </div>
            </form>`;

            modal.innerHTML = formulario



            setTimeout(() => {
                const formulario = document.querySelector('.formulario--tipo-acero');
                formulario.classList.add('animar');
            }, 0);



            modal.addEventListener('click', function (e) {
                e.preventDefault();


                //--------------Aplicando delegation para determinar cuando se dió click en cerrar
                if (e.target.classList.contains('cerrar-modal')) {

                    body.classList.remove('pausar');
                    const formulario = document.querySelector('.formulario--tipo-acero');
                    formulario.classList.add('cerrar');


                    setTimeout(() => {
                        modal.remove();
                    }, 500);
                }


                //--------------Aplicando delegation para determinar cuando se dió click en el input de tipo submit
                if (e.target.classList.contains('submit-nuevo-valor')) {

                    body.classList.remove('pausar');

                    const valor = document.querySelector('#valor').value.trim();

                    if (valor === '') {
                        //Mostrar alerta de error
                        mostrarAlerta('El Valor es obligatorio', 'alerta--error',
                            document.querySelector('.formulario--tipo-acero legend'));
                        return;
                    }

                    if (is_categoria) {

                        agregarCategoria(valor);

                    } else {

                        agregarDescripcion(valor);
                    }

                }


            });



            document.querySelector('.dashboard').appendChild(modal);
        }

        function mostrarAlerta(mensaje, tipo, referencia) {

            const alertaPrevia = document.querySelector('.alerta');
            if (alertaPrevia) {
                alertaPrevia.remove();
            }


            const alerta = document.createElement('DIV');
            alerta.classList.add('alerta', tipo);
            alerta.textContent = mensaje;


            referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);


            setTimeout(() => {
                alerta.remove();
            }, 3000);
        }


        async function agregarCategoria(valor) {
            try {
                const url = '/api/tipos-acero/agregar/categoria';

                const datos = new FormData();
                datos.append('categoria', valor);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo === 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                        window.location.reload();
                    });

                }


            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error!', 'error');
            }

        }

        async function agregarDescripcion(valor) {

            try {
                const url = '/api/tipos-acero/agregar/descripcion';

                const datos = new FormData();
                datos.append('descripcion', valor);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo === 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                        window.location.reload();
                    });

                }


            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error!', 'error');
            }

        }


        function confirmarEliminar(is_categoria = true) {

            if (is_categoria) {
                Swal.fire({
                    title: '¿Eliminar la Categoria Seleccionada?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarCategoria();
                    }
                })
            } else {
                Swal.fire({
                    title: '¿Eliminar la Descripción Seleccionada?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarDescripcion();
                    }
                })
            }

        }

        async function eliminarCategoria() {
            const inputCategoria = document.querySelector('#categoriaacero_id');
            const id = inputCategoria.value;

            if (!id) {
                Swal.fire('Error', 'No Hay Ninguna Categoria Seleccionada', 'error');
                return;
            }

            try {


                const url = "/api/tipos-acero/eliminar/categoria";
                const datos = new FormData();
                datos.append('id', id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                        window.location.reload();
                    });
                }


            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error!', 'error');
            }



        }

        async function eliminarDescripcion() {
            const inputDescripcion = document.querySelector('#descripcionacero_id');
            const id = inputDescripcion.value;

            if (!id) {
                Swal.fire('Error', 'No Hay Ninguna Descripcion Seleccionada', 'error');
                return;
            }

            try {


                const url = "/api/tipos-acero/eliminar/descripcion";
                const datos = new FormData();
                datos.append('id', id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                        window.location.reload();
                    });
                }


            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error!', 'error');
            }



        }


    }


})();