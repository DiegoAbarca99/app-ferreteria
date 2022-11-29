import Swal from 'sweetalert2';
(function () {
    const btnAgregar = document.querySelector('#categoria-producto');
    const btnEliminar = document.querySelector('#categoria-producto-eliminar')

    if (btnAgregar && btnEliminar) {

        btnAgregar.addEventListener('click', mostrarFormulario);

        btnEliminar.addEventListener('click', confirmarEliminar);


        function mostrarFormulario() {

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
            <form class="formulario formulario--producto">

                <legend>Agregar Categoria</legend>
                <div class="formulario__campo"
                    <label class="formulario__label" for="valor">Categoria</label>
                    <input class="formulario__input" type="text" name="valor" id="valor">
                </div>
                 <div class="opciones">
                    <input type="submit" class="submit-nuevo-valor" value="Agregar">
                    <button class="cerrar-modal" type="button">Cancelar </button>
                </div>
            </form>`;

            modal.innerHTML = formulario



            setTimeout(() => {
                const formulario = document.querySelector('.formulario--producto');
                formulario.classList.add('animar');
            }, 0);



            modal.addEventListener('click', function (e) {
                e.preventDefault();


                //--------------Aplicando delegation para determinar cuando se dió click en cerrar
                if (e.target.classList.contains('cerrar-modal')) {

                    body.classList.remove('pausar');
                    const formulario = document.querySelector('.formulario--producto');
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
                            document.querySelector('.formulario--producto legend'));
                        return;
                    } else {
                        agregarCategoria(valor);
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
                const url = '/api/producto-proveedor/agregar/categoria';

                const datos = new FormData();
                datos.append('nombre', valor);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo === 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                        window.location.reload();
                    });

                } else if (resultado.tipo === 'error') {
                    Swal.fire(resultado.mensaje, 'Ha ocurrido un error', 'error');
                }




            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha ocurrido un error!', 'error');
            }

        }


        function confirmarEliminar() {


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



        }

        async function eliminarCategoria() {
            const inputCategoria = document.querySelector('#categoriaProductosProveedores_id');
            const id = inputCategoria.value;

            if (!id) {
                Swal.fire('No Hay Ninguna Categoria Seleccionada', 'Ha Ocurrido Un Error', 'error');
                return;
            }

            try {


                const url = "/api/producto-proveedor/eliminar/categoria";
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
                Swal.fire('Hay Registros Asociados a Está Categoria', 'Ha Ocurrido Un Error', 'error');
            }



        }
    }
})();   