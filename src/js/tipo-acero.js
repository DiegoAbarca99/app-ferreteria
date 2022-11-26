import Swal from 'sweetalert2';

(function () {

    // Determinar el script actual para operar sobre los elementos que están presentes
    const botonesEliminar = document.querySelectorAll('.eliminar-tipoAcero');

    if (botonesEliminar.length) {

        // Itera sobre el conjunto de botones de eliminar que comparten la tabla de tipos de aceros
        botonesEliminar.forEach(boton => boton.addEventListener('click', function (e) {
            e.preventDefault();

            //Se extrae el valor del inputHidden del registro que contiene el botón Seleccionado
            let id = e.target.parentElement.querySelector('.id');
            id = id.value;

            //Modal Interrogativo
            Swal.fire({
                title: '¿Eliminar Registro Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarRegistro(id);
                }
            })

        }));


        async function eliminarRegistro(id) {

            //El registro Maestro que tiene la celda SLP que condiciona este valor para los demás, no puede eliminarse
            if (id == 1) {
                Swal.fire('Error', 'No Es Posible Eliminar Este Registro', 'error');
                return;
            }

            //Conexión con ApiTiposAcero para eliminar el registro seleccionado

            const datos = new FormData();
            datos.append('id', id);

            try {
                const url = "/admin/acero/eliminar";

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.resultado) {
                    //Modal Confirmativo
                    Swal.fire('Eliminado!', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    });



                }

            } catch (error) {
                //Modal Error
                Swal.fire('Error!', 'Ocurrió un error', 'error');
            }
        }



        //Modificar los precios SLP, prolamsa y arcaMetal al dar click a la celda

        let registroActualizar;

        const registros = document.querySelectorAll('.id');
        registros.forEach(registro => {

            //El primer registro es el único en que puede alterarse SLP
            if (registro.value == 1) {

                const registroResaltar = registro.parentElement.parentElement.parentElement.querySelector('.table__td--slp');
                registroResaltar.classList.add('table__td--slp-naranja');


                registroResaltar.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);


                    mostrarFormulario(valor, 'SLP');
                });
            } else {

                //Para los demás registro se modifica ArcoMetal y Prolamsa

                const registroProlamsa = registro.parentElement.parentElement.parentElement.querySelector('.table__td--prolamsa');
                const registroArcoMetal = registro.parentElement.parentElement.parentElement.querySelector('.table__td--arcoMetal');

                registroProlamsa.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);

                    mostrarFormulario(valor, 'Prolamsa');
                });

                registroArcoMetal.addEventListener('click', function (e) {
                    registroActualizar = e.target.parentElement.querySelector('.table__td--acciones').firstElementChild.nextElementSibling.firstElementChild;
                    const valor = parseFloat(e.target.textContent);
                    mostrarFormulario(valor, 'ArcoMetal');
                });


            }

        });



        function mostrarFormulario(valor, tipo) {
            const inicio = document.querySelector('#cerrar-menu');

            //Scroll automatizo para los smarthphones
            if (inicio) {
                inicio.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            const body = document.querySelector('body');
            body.classList.add('pausar');


            const modal = document.createElement('DIV');
            modal.classList.add('modal');


            let formulario = `
            <form class="formulario">

                <legend>Editar ${tipo}</legend>
                <div class="formulario__campo"
                    <label class="formulario__label" for="valor">${tipo}</label>
                    <input class="formulario__input" type="number" step="any" min="0" name="valor" id="valor" value="${valor}">
                </div>
                 <div class="opciones">
                    <input type="submit" class="submit-nuevo-valor" value="Agregar">
                    <button class="cerrar-modal" type="button">Cancelar </button>
                </div>
            </form>`;

            modal.innerHTML = formulario



            setTimeout(() => {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('animar');
            }, 0);



            modal.addEventListener('click', function (e) {
                e.preventDefault();


                //--------------Aplicando delegation para determinar cuando se dió click en cerrar
                if (e.target.classList.contains('cerrar-modal')) {

                    body.classList.remove('pausar');
                    const formulario = document.querySelector('.formulario');
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
                            document.querySelector('.formulario legend'));
                        return;
                    }


                    if (tipo == 'SLP') {

                        editarSLP(valor);
                    } else if (tipo == 'Prolamsa') {

                        editarProlamsa(valor);
                    } else if (tipo == 'ArcoMetal') {
                        editarArcoMetal(valor);
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

        async function editarSLP(valor) {
            try {
                const url = '/api/tipos-acero/actualizar/precios';

                const datos = new FormData();
                datos.append('id', registroActualizar.value);
                datos.append('slp', valor);


                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire('Exito', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    })
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha Ocurrido un Error al Actualizar el Registro', 'error');

            }
        }
        async function editarProlamsa(valor) {
            try {
                const url = '/api/tipos-acero/actualizar/precios';

                const datos = new FormData();
                datos.append('id', registroActualizar.value);
                datos.append('prolamsa', valor);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire('Exito', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    })
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha Ocurrido un Error al Actualizar el Registro', 'error');

            }
        }
        async function editarArcoMetal(valor) {
            try {
                const url = '/api/tipos-acero/actualizar/precios';

                const datos = new FormData();
                datos.append('id', registroActualizar.value);
                datos.append('arcoMetal', valor);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire('Exito', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    })
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Ha Ocurrido un Error al Actualizar el Registro', 'error');

            }
        }


        // Filtra el contenido por categoria seleccionada en el select
        const filtro = document.querySelector('#select-acero');

        filtro.addEventListener('input', function (e) {
            const categoria = e.target.value;

            window.location = `?categoria=${categoria}`;
        });



    }
})();
