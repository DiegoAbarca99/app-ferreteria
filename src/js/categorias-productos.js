
import Swal from 'sweetalert2';
(function () {
    const selectCategorias = document.querySelector('#select-categoria'); //Select de las categorias
    if (selectCategorias) {

        //Variables globales
        let categoriaFiltrada = {};
        let value = '';
        let nombre = '';

        //Evento del select
        selectCategorias.addEventListener('input', function (e) {
            value = e.target.value;
            nombre = document.querySelector(`option[value='${value}']`).textContent;

            filtarCategoria(value);

        });


        // Evento Eliminar categoria seleccionada
        const enlaceEliminar = document.querySelector('#categoria-eliminar');
        enlaceEliminar.addEventListener('click', confirmarEliminarCategoria);

        // Evento editar nombre de la categoria seleccionada
        const enlaceEditar = document.querySelector('#categoria-editar');
        enlaceEditar.addEventListener('click', function () {
            if (value == '') {
                Swal.fire('No Hay Ninguna Categoria Seleccionada', 'Ha Ocurrido Un Error', 'error').then(() => {
                    window.location.reload();
                });

            } else {
                //Se abre modal
                mostrarFormularioNombre();
            }


        });



        async function filtarCategoria(valor) {
            const url = `/api/categorias/filtrar?id=${valor}`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            categoriaFiltrada = resultado;
            mostrarCategoria();

        }




        function mostrarCategoria() {

            const contenedorGanancias = document.querySelector('#ganancias');
            const contenedorImpuestos = document.querySelector('#impuestos');

            limpiarHtml(contenedorGanancias);
            limpiarHtml(contenedorImpuestos);



            const { impuestos, ganancias } = categoriaFiltrada;


            const headingGanancias = document.createElement('CAPTION');
            headingGanancias.innerHTML = '<span>Ganancias</span>';
            headingGanancias.classList.add('table__caption', 'table__caption--categoria');

            contenedorGanancias.appendChild(headingGanancias);

            mostrarGanancias(ganancias);

            const headingImpuestos = document.createElement('CAPTION');
            headingImpuestos.innerHTML = '<span>Impuestos</span>';
            headingImpuestos.classList.add('table__caption', 'table__caption--categoria');

            contenedorImpuestos.appendChild(headingImpuestos);

            mostrarImpuestos(impuestos);




        }

        function mostrarGanancias(ganancias) {

            const contenedor = document.createElement('TR');
            contenedor.classList.add('categoria__grid', 'contenedor-sombra');



            //----------Publico 1--------------------------------------------
            const contenedorPublico1 = document.createElement('TD');
            contenedorPublico1.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingPublico1 = document.createElement('H4');
            headingPublico1.textContent = 'Publico 1';
            headingPublico1.classList.add('categoria__heading--ganancias');

            const cantidadPublico1 = document.createElement('P');
            cantidadPublico1.textContent = `% ${ganancias.gananciapublico1}`;
            cantidadPublico1.classList.add('categoria__cantidad');
            cantidadPublico1.onclick = function () {
                mostrarFormulario(true, 1, { ...ganancias });
            };

            const logo = document.createElement('P');
            logo.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorPublico1.appendChild(logo);
            contenedorPublico1.appendChild(headingPublico1);
            contenedorPublico1.appendChild(cantidadPublico1);

            //----------Herrero 2--------------------------------------------
            const contenedorHerrero2 = document.createElement('TD');
            contenedorHerrero2.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingHerrero2 = document.createElement('H4');
            headingHerrero2.textContent = 'Herrero 2';
            headingHerrero2.classList.add('categoria__heading--ganancias');

            const cantidadHerrero2 = document.createElement('P');
            cantidadHerrero2.textContent = `% ${ganancias.gananciaherrero2}`;
            cantidadHerrero2.classList.add('categoria__cantidad');
            cantidadHerrero2.onclick = function () {
                mostrarFormulario(true, 2, { ...ganancias });
            };

            const logo2 = document.createElement('P');
            logo2.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo2.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorHerrero2.appendChild(logo2);
            contenedorHerrero2.appendChild(headingHerrero2);
            contenedorHerrero2.appendChild(cantidadHerrero2);

            //----------Herrero 3--------------------------------------------
            const contenedorHerrero3 = document.createElement('TD');
            contenedorHerrero3.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingHerrero3 = document.createElement('H4');
            headingHerrero3.textContent = 'Herrero 3';
            headingHerrero3.classList.add('categoria__heading--ganancias');

            const cantidadHerrero3 = document.createElement('P');
            cantidadHerrero3.textContent = `% ${ganancias.gananciaherrero3}`;
            cantidadHerrero3.classList.add('categoria__cantidad');
            cantidadHerrero3.onclick = function () {
                mostrarFormulario(true, 3, { ...ganancias });
            };

            const logo3 = document.createElement('P');
            logo3.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo3.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorHerrero3.appendChild(logo3);
            contenedorHerrero3.appendChild(headingHerrero3);
            contenedorHerrero3.appendChild(cantidadHerrero3);

            //----------Herrero 4--------------------------------------------
            const contenedorHerrero4 = document.createElement('TD');
            contenedorHerrero4.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingHerrero4 = document.createElement('H4');
            headingHerrero4.textContent = 'Herrero 4';
            headingHerrero4.classList.add('categoria__heading--ganancias');

            const cantidadHerrero4 = document.createElement('P');
            cantidadHerrero4.textContent = `% ${ganancias.gananciaherrero4}`;
            cantidadHerrero4.classList.add('categoria__cantidad');
            cantidadHerrero4.onclick = function () {
                mostrarFormulario(true, 4, { ...ganancias });
            };

            const logo4 = document.createElement('P');
            logo4.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo4.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorHerrero4.appendChild(logo4);
            contenedorHerrero4.appendChild(headingHerrero4);
            contenedorHerrero4.appendChild(cantidadHerrero4);

            //----------Mayoreo 1--------------------------------------------
            const contenedorMayoreo1 = document.createElement('TD');
            contenedorMayoreo1.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingMayoreo1 = document.createElement('H4');
            headingMayoreo1.textContent = 'Mayoreo 1';
            headingMayoreo1.classList.add('categoria__heading--ganancias');

            const cantidadMayoreo1 = document.createElement('P');
            cantidadMayoreo1.textContent = `% ${ganancias.gananciamayoreo1}`;
            cantidadMayoreo1.classList.add('categoria__cantidad');
            cantidadMayoreo1.onclick = function () {
                mostrarFormulario(true, 5, { ...ganancias });
            };

            const logo5 = document.createElement('P');
            logo5.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo5.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorMayoreo1.appendChild(logo5);
            contenedorMayoreo1.appendChild(headingMayoreo1);
            contenedorMayoreo1.appendChild(cantidadMayoreo1);

            //----------Mayoreo 2--------------------------------------------
            const contenedorMayoreo2 = document.createElement('TD');
            contenedorMayoreo2.classList.add('categoria__bloque--ganancias', 'categoria__bloque');

            const headingMayoreo2 = document.createElement('H4');
            headingMayoreo2.textContent = 'Mayoreo 2';
            headingMayoreo2.classList.add('categoria__heading--ganancias');

            const cantidadMayoreo2 = document.createElement('P');
            cantidadMayoreo2.textContent = `% ${ganancias.gananciamayoreo2}`;
            cantidadMayoreo2.classList.add('categoria__cantidad');
            cantidadMayoreo2.onclick = function () {
                mostrarFormulario(true, 6, { ...ganancias });
            };

            const logo6 = document.createElement('P');
            logo6.classList.add('categoria__logo', 'categoria__logo--ganancias');
            logo6.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorMayoreo2.appendChild(logo6);
            contenedorMayoreo2.appendChild(headingMayoreo2);
            contenedorMayoreo2.appendChild(cantidadMayoreo2);





            //---------Contenedor bloque ganancia----------
            contenedor.appendChild(contenedorPublico1);
            contenedor.appendChild(contenedorHerrero2);
            contenedor.appendChild(contenedorHerrero3);
            contenedor.appendChild(contenedorHerrero4);
            contenedor.appendChild(contenedorMayoreo1);
            contenedor.appendChild(contenedorMayoreo2);

            //--------Contenedor bloques de ganancias
            const gananciasContenedor = document.querySelector('#ganancias');
            gananciasContenedor.appendChild(contenedor);



        }


        function mostrarImpuestos(impuestos) {
            const contenedor = document.createElement('TR');
            contenedor.classList.add('categoria__grid', 'contenedor-sombra');



            //----------IVA--------------------------------------------
            const contenedorIva = document.createElement('TD');
            contenedorIva.classList.add('categoria__bloque--impuestos', 'categoria__bloque');

            const headingIva = document.createElement('H4');
            headingIva.textContent = 'IVA';
            headingIva.classList.add('categoria__heading--impuestos');

            const cantidadIva = document.createElement('P');
            cantidadIva.textContent = `${impuestos.iva}`;
            cantidadIva.classList.add('categoria__cantidad--impuestos');
            cantidadIva.onclick = function () {
                mostrarFormulario(false, 1, { ...impuestos });
            };

            const logo = document.createElement('P');
            logo.classList.add('categoria__logo', 'categoria__logo--impuestos');
            logo.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorIva.appendChild(logo);
            contenedorIva.appendChild(headingIva);
            contenedorIva.appendChild(cantidadIva);

            //----------Flete--------------------------------------------
            const contenedorFlete = document.createElement('TD');
            contenedorFlete.classList.add('categoria__bloque--impuestos', 'categoria__bloque');

            const headingFlete = document.createElement('H4');
            headingFlete.textContent = 'Flete';
            headingFlete.classList.add('categoria__heading--impuestos');

            const cantidadFlete = document.createElement('P');
            cantidadFlete.textContent = `${impuestos.flete}`;
            cantidadFlete.classList.add('categoria__cantidad--impuestos');
            cantidadFlete.onclick = function () {
                mostrarFormulario(false, 2, { ...impuestos });
            };

            const logo2 = document.createElement('P');
            logo2.classList.add('categoria__logo', 'categoria__logo--impuestos');
            logo2.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorFlete.appendChild(logo2);
            contenedorFlete.appendChild(headingFlete);
            contenedorFlete.appendChild(cantidadFlete);

            //----------Descarga--------------------------------------------
            const contenedorDescarga = document.createElement('TD');
            contenedorDescarga.classList.add('categoria__bloque--impuestos', 'categoria__bloque');

            const headingDescarga = document.createElement('H4');
            headingDescarga.textContent = 'Descarga';
            headingDescarga.classList.add('categoria__heading--impuestos');

            const cantidadDescarga = document.createElement('P');
            cantidadDescarga.textContent = `${impuestos.descarga}`;
            cantidadDescarga.classList.add('categoria__cantidad--impuestos');
            cantidadDescarga.onclick = function () {
                mostrarFormulario(false, 3, { ...impuestos });
            };

            const logo3 = document.createElement('P');
            logo3.classList.add('categoria__logo', 'categoria__logo--impuestos');
            logo3.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorDescarga.appendChild(logo3);
            contenedorDescarga.appendChild(headingDescarga);
            contenedorDescarga.appendChild(cantidadDescarga);

            //----------Seguro--------------------------------------------
            const contenedorSeguro = document.createElement('TD');
            contenedorSeguro.classList.add('categoria__bloque--impuestos', 'categoria__bloque');

            const headingSeguro = document.createElement('H4');
            headingSeguro.textContent = 'Seguro';
            headingSeguro.classList.add('categoria__heading--impuestos');

            const cantidadSeguro = document.createElement('P');
            cantidadSeguro.textContent = `${impuestos.seguro}`;
            cantidadSeguro.classList.add('categoria__cantidad--impuestos');
            cantidadSeguro.onclick = function () {
                mostrarFormulario(false, 4, { ...impuestos });
            };

            const logo4 = document.createElement('P');
            logo4.classList.add('categoria__logo', 'categoria__logo--impuestos');
            logo4.innerHTML = `<i class="fa-solid fa-dollar-sign"></i>`;

            contenedorSeguro.appendChild(logo4);
            contenedorSeguro.appendChild(headingSeguro);
            contenedorSeguro.appendChild(cantidadSeguro);



            //---------Contenedor bloque ganancia----------
            contenedor.appendChild(contenedorIva);
            contenedor.appendChild(contenedorFlete);
            contenedor.appendChild(contenedorDescarga);
            contenedor.appendChild(contenedorSeguro);


            //--------Contenedor bloques de impuestos
            const impuestosContenedor = document.querySelector('#impuestos');
            impuestosContenedor.appendChild(contenedor);

        }

        function mostrarFormulario(is_ganancia, tipo, objeto = {}) {
            let formulario;

            //Scroll automaticó al modal desplegado
            const inicio = document.querySelector('#cerrar-menu');
            if (inicio) {
                inicio.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            //Imposibilita hacer es scroll con el modal activo
            const body = document.querySelector('body');
            body.classList.add('pausar');

            const modal = document.createElement('DIV');
            modal.classList.add('modal');

            formulario += `
            <form class="formulario">

                <legend>${is_ganancia ? 'Editar Porcentaje de Ganancia' : 'Editar Impuesto'}</legend>
            `;

            formulario += ` 
                <div class="formulario__campo">`;
            switch (tipo) {
                case 1:
                    formulario += ` 
                            <label class="formulario__label" for="valor">${is_ganancia ? 'Publico1' : 'Iva'}</label>
                            <input class="formulario__input" step="any" type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciapublico1 : objeto.iva}"> </input>
                        </div>`;
                    break;
                case 2:
                    formulario += `
                            <label class="formulario__label" for="valor">${is_ganancia ? 'Herrero2' : 'Flete'}</label>
                            <input class="formulario__input" step="any" type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciaherrero2 : objeto.flete}"> </input>
                        </div>`;
                    break;
                case 3:
                    formulario += `
                            <label class="formulario__label" for="valor">${is_ganancia ? 'Herrero3' : 'Descarga'}</label>
                            <input class="formulario__input" step="any" type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciaherrero3 : objeto.descarga}"> </input>
                        </div>`;
                    break;
                case 4:
                    formulario += `
                            <label class="formulario__label" for="valor">${is_ganancia ? 'Herrero4' : 'Seguro'}</label>
                            <input class="formulario__input" step="any" type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciaherrero4 : objeto.seguro}"> </input>
                        </div>`;
                    break;
                case 5:
                    formulario += `
                            <label class="formulario__label" for="valor">${is_ganancia ? 'Mayoreo1' : ''}</label>
                            <input class="formulario__input" step="any" type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciamayoreo1 : ''}"> </input>
                        </div>`;
                    break;
                case 6:
                    formulario += `
                            <label class="formulario__label"  for="valor">${is_ganancia ? 'Mayoreo2' : ''}</label>
                            <input class="formulario__input" step="any"  type="number" min="0" name="valor" id="valor"  value="${is_ganancia ? objeto.gananciamayoreo2 : ''}"> </input>
                        </div>`;
                    break;

                default:
                    break;
            }

            formulario += `
                <div class="opciones">
                    <input type="submit" class="submit-nuevo-valor" value="Guardar Cambios"></input>
                    <button class="cerrar-modal" type="button">Cancelar </button>
                </div>
            </form >`;

            modal.innerHTML = formulario;


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

                    //Evita que se remueva inmediatamente para poder visualizar la transition de sass
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

                    if (is_ganancia) {
                        //Actualizar objeto de ganancias
                        switch (tipo) {
                            case 1:
                                objeto.gananciapublico1 = valor;
                                break;
                            case 2:
                                objeto.gananciaherrero2 = valor;
                                break;
                            case 3:
                                objeto.gananciaherrero3 = valor;
                                break;
                            case 4:
                                objeto.gananciaherrero4 = valor;
                                break;
                            case 5:
                                objeto.gananciamayoreo1 = valor;
                                break;
                            case 6:
                                objeto.gananciamayoreo2 = valor;
                                break;

                            default:
                                break;
                        }

                        actualizarGanancias(objeto);

                    } else {

                        //Actualizar objeto de impuestos

                        switch (tipo) {
                            case 1:
                                objeto.iva = valor;
                                break;
                            case 2:
                                objeto.flete = valor;
                                break;
                            case 3:
                                objeto.descarga = valor;
                                break;
                            case 4:
                                objeto.seguro = valor;
                                break;

                            default:
                                break;
                        }

                        actualizarImpuestos(objeto);
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

        async function actualizarGanancias(gananciaActualizar = {}) {
            const { id, gananciapublico1, gananciaherrero2, gananciaherrero3, gananciaherrero4, gananciamayoreo1, gananciamayoreo2 } = gananciaActualizar;
            const url = '/api/categorias/actualizar/ganancias';

            const datos = new FormData();
            datos.append('id', id);
            datos.append('gananciapublico1', gananciapublico1);
            datos.append('gananciaherrero2', gananciaherrero2);
            datos.append('gananciaherrero3', gananciaherrero3);
            datos.append('gananciaherrero4', gananciaherrero4);
            datos.append('gananciamayoreo1', gananciamayoreo1);
            datos.append('gananciamayoreo2', gananciamayoreo2);

            try {

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo === 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success');

                    const modal = document.querySelector('.modal');
                    if (modal) {
                        modal.remove();
                    }


                    if (categoriaFiltrada.porcentajeGanancias_id == id) {
                        categoriaFiltrada.ganancias.gananciapublico1 = gananciapublico1;
                        categoriaFiltrada.ganancias.gananciaherrero2 = gananciaherrero2;
                        categoriaFiltrada.ganancias.gananciaherrero3 = gananciaherrero3;
                        categoriaFiltrada.ganancias.gananciaherrero4 = gananciaherrero4;
                        categoriaFiltrada.ganancias.gananciamayoreo1 = gananciamayoreo1;
                        categoriaFiltrada.ganancias.gananciamayoreo2 = gananciamayoreo2;
                    }


                    mostrarCategoria();



                }


            } catch (error) {


                Swal.fire('Error', 'Ha ocurrido un error!', 'error');

                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();
                }


            }


        }


        async function actualizarImpuestos(impuestoActualizar = {}) {
            const { id, iva, flete, descarga, seguro } = impuestoActualizar;
            const url = '/api/categorias/actualizar/impuestos';

            const datos = new FormData();
            datos.append('id', id);
            datos.append('iva', iva);
            datos.append('flete', flete);
            datos.append('descarga', descarga);
            datos.append('seguro', seguro);


            try {

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();


                if (resultado.tipo === 'exito') {
                    Swal.fire(resultado.mensaje, 'Operación exitosa', 'success');

                    const modal = document.querySelector('.modal');
                    if (modal) {
                        modal.remove();
                    }



                    if (categoriaFiltrada.impuestos_id == id) {
                        categoriaFiltrada.impuestos.iva = iva;
                        categoriaFiltrada.impuestos.flete = flete;
                        categoriaFiltrada.impuestos.descarga = descarga;
                        categoriaFiltrada.impuestos.seguro = seguro;

                    }


                    mostrarCategoria();






                }


            } catch (error) {


                Swal.fire('Error', 'Ha ocurrido un error!', 'error');

                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();
                }


            }
        }

        function mostrarFormularioNombre() {
            let formulario;

            const body = document.querySelector('body');
            body.classList.add('pausar');

            const modal = document.createElement('DIV');
            modal.classList.add('modal');

            formulario =
                `<form class="formulario">

                    <legend> Editar Nombre </legend>

                    <div class="formulario__campo"
                        <label class="formulario__label" for="valor">Nombre</label>
                        <input class="formulario__input" type="text" name="valor" id="valor" value="${nombre}">
                     </div>

                    <div class="opciones">
                        <input type="submit" class="submit-nuevo-valor" value="Agregar">
                        <button class="cerrar-modal" type="button">Cancelar </button>
                    </div>

                </form>`;


            modal.innerHTML = formulario;


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
                    } else {
                        actualizarNombre(valor);

                    }



                }



            });



            document.querySelector('.dashboard').appendChild(modal);

        }


        async function actualizarNombre(valor) {

            try {
                const url = "/api/categorias/actualizar/nombre";

                const datos = new FormData();
                datos.append('id', value);
                datos.append('nombre', valor);

                const respuesta = await fetch(url, {
                    body: datos,
                    method: 'POST'
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire(resultado.mensaje, 'Exito', 'success').then(() => {
                        window.location.reload();
                    });
                } else if (resultado.tipo == 'error') {
                    Swal.fire(resultado.mensaje, 'Error', 'error').then(() => {
                        window.location.reload();
                    });
                }

            } catch (error) {
                console.log(error);
                Swal.fire('Ha ocurrido un error', 'Error', 'error').then(() => {
                    window.location.reload();
                });
            }

        }


        function confirmarEliminarCategoria() {

            Swal.fire({
                title: '¿Eliminar la Categoría Seleccionada?',
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


            if (!value) {
                Swal.fire('No Hay Ninguna Categoria Seleccionada', 'Ha Ocurrido Un Error', 'error');
                return;
            }


            try {

                const url = "/api/categorias/eliminar";
                const datos = new FormData();
                datos.append('id', value);

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
                Swal.fire('Hay Registros Asociados a Está Categoria', 'Ha ocurrido un error', 'error');
            }
        }





        function limpiarHtml(contenedor) {

            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }

    }
})();