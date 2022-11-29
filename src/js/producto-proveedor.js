import Swal from 'sweetalert2';
(function () {
    const filtro = document.querySelector('#select-producto-proveedor');
    const buscador =document.querySelector('#buscador');
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    const botonesEditar = document.querySelectorAll('.table__td--resaltar');


    if (filtro) {

        filtro.addEventListener('input', function (e) {
            const categoria = e.target.value;

            window.location = `?categoria=${categoria}`;
        });

        buscador.addEventListener('click',function(e){
            e.preventDefault();
            const nombre =e.target.parentElement.querySelector('input').value;
            window.location = `?nombre=${nombre}`;
        })

        let id;
        let peso;

        botonesEliminar.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                id = e.target.parentElement.querySelector('input').value;

                confirmarEliminar();
            });
        });


        botonesEditar.forEach(btn => {
            btn.addEventListener('click', function (e) {
                id = e.target.parentElement.querySelector('.eliminar-productoProveedor').value;
                peso = e.target.textContent;

                mostrarFormulario();



            });
        });



        function confirmarEliminar() {


            Swal.fire({
                title: '¿Eliminar el Registro Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarRegistro();
                }
            })



        }

        async function eliminarRegistro() {


            try {


                const url = "/api/producto-proveedor/eliminar";
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
                }else{
                    Swal.fire('Ha Ocurrido Un Error', 'error', 'error');
                }


            } catch (error) {
                console.error(error);
                Swal.fire('Ha Ocurrido Un Error', 'error', 'error');
            }



        }

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

                <legend>Cambiar Peso</legend>
                <div class="formulario__campo"
                    <label class="formulario__label" for="valor">Nuevo Peso</label>
                    <input class="formulario__input" type="text" name="valor" id="valor" value='${peso}'>
                </div>
                 <div class="opciones">
                    <input type="submit" class="submit-nuevo-valor" value="Cambiar">
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
                        editarPeso(valor);
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

        async function editarPeso(valor) {

            try {
                const url = "/api/producto-proveedor/actualizar/peso";

                const datos = new FormData();
                datos.append('peso', valor);
                datos.append('id', id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire(resultado.mensaje, resultado.tipo, 'success').then(() => {
                        window.location.reload();
                    });

                }

            } catch (error) {

                console.error(error);

                Swal.fire('Ha Ocurrido un Error', 'error', 'error');
            }




        }



    }
})();