const { default: Swal } = require("sweetalert2");

(function () {
    const pedido = document.querySelector('#pedido');
    if (pedido) {

        let paso = 1;
        const pasoInicial = 1;
        const pasoFinal = 4;

        let pedido = {
            usuarios_id: '',
            cliente: '',
            nombre: '',
            credito: '',
            cuota: '',
            rfc: '',
            telefono: '',
            direccion: '',
            ubicacion: '',
            total: '',
            metodoPago: '',
            status: '',
            pagado: '',
            productos: [],
            productoskilos: [],



        }

        mostrarSeccion();
        botonesPaginador();
        paginaAnterior();
        paginaSiguiente();
        preciosKilo();


        function mostrarSeccion() {

            const seccionAnterior = document.querySelector('.mostrar')

            if (seccionAnterior) {
                seccionAnterior.classList.remove('mostrar');
            }

            const seccion = document.querySelector(`#paso-${paso}`);
            seccion.classList.add('mostrar');
        }

        function botonesPaginador() {
            const paginaAnterior = document.querySelector('#anterior');
            const paginaSiguiente = document.querySelector('#siguiente');
            paginaSiguiente.disabled = false;

            if (paso === 1) {
                paginaAnterior.classList.add('ocultar');
                paginaSiguiente.classList.remove('ocultar')

            } else if (paso === 2 || paso === 3) {
                paginaAnterior.classList.remove('ocultar');
                paginaSiguiente.classList.remove('ocultar');


                if (paso == 2 && (pedido.cliente == '' || (pedido.productos.length == 0 && pedido.productoskilos.length == 0))) {
                    paginaSiguiente.disabled = true;
                }

                if (paso == 3) {
                    mostrarResumen();
                }



            } else {
                paginaAnterior.classList.remove('ocultar');
                paginaSiguiente.classList.add('ocultar');
                validarPedido();
            }

            mostrarSeccion();
        }

        function paginaAnterior() {
            const paginaAnterior = document.querySelector('#anterior');

            paginaAnterior.addEventListener('click', function () {

                if (paso <= pasoInicial) return;
                paso--;


                botonesPaginador(); //Para hacer que se muestre los botones pertinentes en base al valor del paso dado por esta función
            })
        }

        function paginaSiguiente() {
            const paginaSiguiente = document.querySelector('#siguiente');

            paginaSiguiente.addEventListener('click', function () {

                if (paso >= pasoFinal) return;
                paso++;

                botonesPaginador(); //Para hacer que se muestre los botones pertinentes en base al valor del paso dado por esta función
            })
        }

        function preciosKilo() {
            const botonKilos = document.querySelector('#precios-kilos');
            botonKilos.addEventListener('click', function (e) {
                e.preventDefault();

                const seccionAnterior = document.querySelector('.mostrar');
                seccionAnterior.classList.remove('mostrar');

                const seccion = document.querySelector('#seccion-kilos');
                seccion.classList.toggle('mostrar');

                const regresar = document.querySelector('#precios-comerciales');
                regresar.addEventListener('click', function (e) {
                    e.preventDefault();
                    paso = 2;
                    mostrarSeccion();
                })

            })
        }

        //---------------------Obtener Clientes-------------------------------------------------------------------------------------
        const selectMunicipio = document.querySelector('#select-municipio');

        if (selectMunicipio) {
            let clientes = [];


            selectMunicipio.addEventListener('change', (e) => {
                const id = e.target.value;

                obtenerClientes(id);

            });

            const buscadorCliente = document.querySelector('#buscador-cliente');


            buscadorCliente.addEventListener('submit', (e) => {
                e.preventDefault();

                const contenedorClientes = document.querySelector('#clientes');

                limpiarHtml(contenedorClientes);


                if (clientes.length == 0) {

                    const contenedorMensaje = document.createElement('DIV');

                    const mensajeHeading = document.createElement('P');
                    mensajeHeading.textContent = 'Debe seleccionar un municipio primero.';

                    contenedorMensaje.appendChild(mensajeHeading);
                    contenedorClientes.appendChild(contenedorMensaje);
                } else {

                    const busqueda = e.target.querySelector('#buscar-cliente').value;
                    let clientesFiltrados = [];

                    if (busqueda.trim().length > 3) {

                        const expresion = RegExp(busqueda, 'i');
                        clientesFiltrados = clientes.filter(cliente => {

                            if (cliente.nombre.toLowerCase().search(expresion) != -1) {
                                return cliente;
                            }

                        });

                        if (clientesFiltrados.length > 0) {
                            mostrarClientes(clientesFiltrados);
                        } else {
                            const contenedorMensaje = document.createElement('DIV');

                            const mensajeHeading = document.createElement('P');
                            mensajeHeading.textContent = 'No hay ningún resultado asociado.';

                            contenedorMensaje.appendChild(mensajeHeading);
                            contenedorClientes.appendChild(contenedorMensaje);
                        }

                    }


                }

            });

            async function obtenerClientes(id) {
                const url = `/api/clientes?id=${id}`;

                const respuesta = await fetch(url);
                clientes = await respuesta.json();

                mostrarClientes(clientes);


            }

            function mostrarClientes(clientesFiltrados) {

                const contenedorClientes = document.querySelector('#clientes');

                limpiarHtml(contenedorClientes);

                clientesFiltrados.map(cliente => {

                    const bloqueCliente = document.createElement('DIV');
                    bloqueCliente.classList.add('bloque-producto');
                    if (pedido.cliente == cliente.id) {
                        bloqueCliente.classList.add('bloque-producto--seleccionado');
                    }

                    const heading = document.createElement('H3');
                    heading.classList.add('bloque-producto__heading');
                    heading.innerHTML = `<span class="bloque-producto__heading--resaltar" data-id="${cliente.id}">Nombre:</span> ${cliente.nombre}`;

                    bloqueCliente.appendChild(heading);

                    bloqueCliente.onclick = function () {
                        mostrarCliente(cliente);
                    };

                    contenedorClientes.appendChild(bloqueCliente);


                });


            }

            function mostrarCliente(cliente) {


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
    
                    <legend>${cliente.nombre}</legend>
                    <div class="grid">
                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Estado</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.estado}">
    
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Municipio</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.municipio.nombre}">
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Colonia</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.colonia}">
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Telefono</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.telefono}">
                            </div>

                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Crédito</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.credito == 1 ? 'Activo' : 'Inactivo'}">
                            </div>

                            <div class="formulario__campo"
                                <label class="formulario__label" for="valor">Cuota Consumo</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.cuotaConsumo ? cliente.cuotaConsumo : '0.00'}">
                            </div>

                            <div class="formulario__campo grid__expandir"
                                <label class="formulario__label" for="valor">Direcciòn</label>
                                <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${cliente.calle} #${cliente.numeroExterno} #${cliente.numeroInterno}">
                            </div>
                    </div>
                            <div class="opciones">
                                <button class="btn-verde seleccionar" type="button">Seleccionar</button>
                                <button type="submit" class="btn-editar"">Editar</button>
                                <button class="cerrar-modal" type="button">Cancelar</button>
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


                    if (e.target.classList.contains('btn-editar')) {
                        window.location.href = `/proveedor/clientes/actualizar?id=${cliente.id}`;
                    }


                    if (e.target.classList.contains('seleccionar')) {

                        const clienteAnterior = document.querySelector('.bloque-producto--seleccionado');

                        if (clienteAnterior) {
                            clienteAnterior.classList.remove('bloque-producto--seleccionado');
                            pedido.cliente = '';

                        }
                        const clienteSeleccionado = document.querySelector(`[data-id='${cliente.id}']`);
                        clienteSeleccionado.parentElement.parentElement.classList.add('bloque-producto--seleccionado');

                        pedido.cliente = cliente.id;
                        pedido.direccion = `${cliente.calle} #${cliente.numeroExterno} #${cliente.numeroInterno}`;
                        pedido.nombre = cliente.nombre;
                        pedido.ubicacion = `${cliente.estado}, ${cliente.municipio.nombre}`;
                        pedido.credito = cliente.credito == 0 ? 'Inactivo' : 'Activo';
                        pedido.cuota = cliente.cuota ?? '0.00';
                        pedido.rfc = cliente.rfc;
                        pedido.telefono = cliente.telefono;





                        body.classList.remove('pausar');
                        const formulario = document.querySelector('.formulario--producto');
                        formulario.classList.add('cerrar');


                        setTimeout(() => {
                            modal.remove();
                        }, 500);


                    }


                });



                document.querySelector('.dashboard').appendChild(modal);


            }



        }

        //-----Seleccionar productos ----------------------------------------------------------------------------------------------
        const selectCategoria = document.querySelector('#select-producto');


        if (selectCategoria) {

            const buscadorProducto = document.querySelector('#buscador-producto');
            let productosFormateados = [];

            selectCategoria.addEventListener('change', (e) => {
                const id = e.target.value;

                obtenerProductos(id);

            });

            buscadorProducto.addEventListener('submit', (e) => {
                e.preventDefault();

                const contenedorProductos = document.querySelector('#productos');

                limpiarHtml(contenedorProductos);





                if (productosFormateados.length == 0) {

                    const contenedorMensaje = document.createElement('DIV');

                    const mensajeHeading = document.createElement('P');
                    mensajeHeading.textContent = 'Debe seleccionar una categoria primero.';

                    contenedorMensaje.appendChild(mensajeHeading);
                    contenedorProductos.appendChild(contenedorMensaje);
                } else {

                    const busqueda = e.target.querySelector('input[type="text"]').value;
                    let productosFiltrados = [];

                    if (busqueda.trim().length > 0) {

                        const expresion = RegExp(busqueda, 'i');
                        productosFiltrados = productosFormateados.filter(producto => {


                            if (producto.nombre.toLowerCase().search(expresion) != -1) {
                                return producto;
                            }

                        });

                        if (productosFiltrados.length > 0) {
                            mostrarProductos(productosFiltrados);
                        } else {
                            const contenedorMensaje = document.createElement('DIV');

                            const mensajeHeading = document.createElement('P');
                            mensajeHeading.textContent = 'No hay ningún resultado asociado.';

                            contenedorMensaje.appendChild(mensajeHeading);
                            contenedorProductos.appendChild(contenedorMensaje);
                        }

                    }


                }

            });

            async function obtenerProductos(id) {
                const url = `/api/productos?id=${id}`;

                const respuesta = await fetch(url);
                const resultado = await respuesta.json();


                formatearProductos(resultado);

            }

            function formatearProductos(productos) {

                productosFormateados = productos.map(elemento => {
                    return {
                        id: elemento.id,
                        nombre: elemento.categoria.nombre + ' ' + elemento.nombre,
                        precio: elemento.precio
                    }
                });


                mostrarProductos(productosFormateados);


            }

            function mostrarProductos(productos) {
                const contenedorProductos = document.querySelector('#productos');

                limpiarHtml(contenedorProductos);


                productos.map(producto => {

                    const bloqueProducto = document.createElement('DIV');
                    bloqueProducto.classList.add('bloque-producto');
                    bloqueProducto.dataset.idProducto = producto.id;
                    if (pedido.productos.some(elemento => elemento.id == producto.id)) {
                        bloqueProducto.classList.add('bloque-producto--seleccionado');
                    }


                    const heading = document.createElement('H3');
                    heading.classList.add('bloque-producto__heading');
                    heading.innerHTML = `<span class="bloque-producto__heading--resaltar">Nombre:</span> ${producto.nombre}`;

                    bloqueProducto.appendChild(heading);

                    bloqueProducto.onclick = function () {
                        mostrarInformacion(producto);
                    };

                    contenedorProductos.appendChild(bloqueProducto);


                });


            }

            function mostrarInformacion(producto) {
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
    
                    <legend>${producto.nombre}</legend>
                    <div class="grid">
                            <div class="formulario__campo"
                                <label class="formulario__label" for="publico1">Publico1</label>
                                <p class="formulario__descripcion publico1" id="publico1">${producto.precio.publico1}</p>
    
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero2">Herrero2</label>
                                <p class="formulario__descripcion herrero2" id="herrero2">${producto.precio.herrero2}</p>
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero3">Herrero3</label>
                                <p class="formulario__descripcion herrero3" id="herrero3">${producto.precio.herrero3} </p>
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero4">Herrero4</label>
                                <p class="formulario__descripcion herrero4" id="herrero4">${producto.precio.herrero4}</p>
                            </div>

                            <div class="formulario__campo"
                                <label class="formulario__label" for="cantidad">Cantidad</label>
                                <input class="formulario__input" type="number" min="0" name="cantidad" id="cantidad">
                            </div>
                    </div>
                            <div class="opciones">
                                <button class="btn-verde seleccionar" type="button">Seleccionar</button>
                                <button type="button" class="btn-editar">Subir de Nivel</button>
                                <button class="cerrar-modal" type="button">Cancelar</button>
                            </div> 
                
                </form>`;

                modal.innerHTML = formulario



                setTimeout(() => {
                    const formulario = document.querySelector('.formulario--producto');
                    formulario.classList.add('animar');




                    const inputCantidad = document.querySelector('#cantidad');
                    pedido.productos.forEach(elemento => {
                        if (elemento.id == producto.id) {
                            inputCantidad.value = elemento.cantidad;

                            if (elemento.publico1) {
                                const publico1 = document.querySelector('#publico1');
                                publico1.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero2) {
                                const herrero2 = document.querySelector('#herrero2');
                                herrero2.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero3) {
                                const herrero3 = document.querySelector('#herrero3');
                                herrero3.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero4) {
                                const herrero4 = document.querySelector('#herrero4');
                                herrero4.classList.add('formulario__descripcion--resaltar')
                            }
                        }


                    });

                }, 0);


                let precio = '';
                let publico1 = false;
                let herrero2 = false;
                let herrero3 = false;
                let herrero4 = false;
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

                    const precioPrevio = document.querySelector('.formulario__descripcion--resaltar');
                    if (e.target.classList.contains('publico1')) {


                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.publico1;
                            herrero4 = false;
                            herrero3 = false;
                            herrero2 = false;
                            publico1 = true;
                            document.querySelector('.publico1').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero2')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero2;
                            herrero4 = false;
                            herrero3 = false;
                            herrero2 = true;
                            publico1 = false;
                            document.querySelector('.herrero2').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero3')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero3;
                            herrero4 = false;
                            herrero3 = true;
                            herrero2 = false;
                            publico1 = false;
                            document.querySelector('.herrero3').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero4')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero4;
                            herrero4 = true;
                            herrero3 = false;
                            herrero2 = false;
                            publico1 = false;
                            document.querySelector('.herrero4').classList.add('formulario__descripcion--resaltar');
                        }

                    }


                    if (e.target.classList.contains('seleccionar')) {
                        const cantidad = document.querySelector('#cantidad').value;


                        const obj = {
                            id: producto.id,
                            nombre: producto.nombre,
                            cantidad: cantidad,
                            precio: precio,
                            publico1: publico1,
                            herrero2: herrero2,
                            herrero3: herrero3,
                            herrero4: herrero4,
                            tipo: 'convencional'

                        };

                        let esIgual = false;
                        pedido.productos = pedido.productos.map(elemento => {
                            if (elemento.id == producto.id) {
                                elemento.cantidad = cantidad;
                                elemento.precio = precio;
                                elemento.publico1 = publico1;
                                elemento.herrero2 = herrero2;
                                elemento.herrero3 = herrero3;
                                elemento.herrero4 = herrero4;
                                esIgual = true;
                            }

                            return elemento;
                        })


                        if (esIgual && (!cantidad || !precio)) {
                            Swal.fire({
                                title: '¿Resetear Información?',
                                showCancelButton: true,
                                confirmButtonText: 'Si',
                                cancelButtonText: 'No',
                                icon: 'question'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    pedido.productos = pedido.productos.filter(elemento => elemento.id != producto.id);


                                    const productoSeleccionado = document.querySelector(`[data-id-producto='${producto.id}']`);
                                    productoSeleccionado.classList.remove('bloque-producto--seleccionado');


                                    body.classList.remove('pausar');
                                    const formulario = document.querySelector('.formulario--producto');
                                    formulario.classList.add('cerrar');


                                    setTimeout(() => {
                                        modal.remove();
                                    }, 500);

                                    botonesPaginador();
                                }
                            })

                        } else if ((!cantidad || !precio)) {
                            Swal.fire('Debe seleccionar un precio y una cantidad', 'Error', 'error');

                        } else if (!esIgual) {

                            pedido.productos = [...pedido.productos, obj];

                            const productoSeleccionado = document.querySelector(`[data-id-producto='${producto.id}']`);
                            productoSeleccionado.classList.add('bloque-producto--seleccionado');


                            body.classList.remove('pausar');
                            const formulario = document.querySelector('.formulario--producto');
                            formulario.classList.add('cerrar');


                            setTimeout(() => {
                                modal.remove();
                            }, 500);

                        } else if (esIgual) {
                            body.classList.remove('pausar');
                            const formulario = document.querySelector('.formulario--producto');
                            formulario.classList.add('cerrar');


                            setTimeout(() => {
                                modal.remove();
                            }, 500);
                        }

                        botonesPaginador();

                    }


                });



                document.querySelector('.dashboard').appendChild(modal);

            }


        }


        //----------------Seleccionar productos por KG--------------------------------------------------------------------------
        const buscadorProducto = document.querySelector("#buscador-producto-kilo");

        if (buscadorProducto) {

            let productos = [];
            obtenerProductosKilos();



            buscadorProducto.addEventListener('submit', (e) => {
                e.preventDefault();

                const contenedorProductos = document.querySelector('#productos-kilos');

                limpiarHtml(contenedorProductos);


                const busqueda = e.target.querySelector('input[type="text"]').value;
                let productosFiltrados = [];

                if (busqueda.trim().length > 0) {

                    const expresion = RegExp(busqueda, 'i');
                    productosFiltrados = productos.filter(producto => {

                        if (producto.nombre.toLowerCase().search(expresion) != -1) {
                            return producto;
                        }

                    });

                    if (productosFiltrados.length > 0) {
                        mostrarProductosKilos(productosFiltrados);
                    } else {
                        const contenedorMensaje = document.createElement('DIV');

                        const mensajeHeading = document.createElement('P');
                        mensajeHeading.textContent = 'No hay ningún resultado asociado.';

                        contenedorMensaje.appendChild(mensajeHeading);
                        contenedorProductos.appendChild(contenedorMensaje);
                    }

                }




            });

            async function obtenerProductosKilos() {
                const url = '/api/productos/kilos';

                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                productos = resultado;

                mostrarProductosKilos();
            }

            function mostrarProductosKilos() {
                const contenedorProductos = document.querySelector('#productos-kilos');

                limpiarHtml(contenedorProductos);

                if (productos.length == 0) {

                    const contenedorMensaje = document.createElement('DIV');

                    const mensajeHeading = document.createElement('P');
                    mensajeHeading.textContent = 'No hay productos todavia.';

                    contenedorMensaje.appendChild(mensajeHeading);
                    contenedorProductos.appendChild(contenedorMensaje);

                } else {

                    productos.map(producto => {

                        const bloqueProducto = document.createElement('DIV');
                        bloqueProducto.classList.add('bloque-producto');
                        bloqueProducto.dataset.idProductokilo = producto.id

                        const heading = document.createElement('H3');
                        heading.classList.add('bloque-producto__heading');
                        heading.innerHTML = `<span class="bloque-producto__heading--resaltar">Nombre:</span> ${producto.nombre}`;

                        bloqueProducto.appendChild(heading);

                        bloqueProducto.onclick = function () {
                            mostrarInformacion(producto);
                        };

                        contenedorProductos.appendChild(bloqueProducto);


                    });

                }
            }

            function mostrarInformacion(producto) {
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
    
                    <legend>${producto.nombre}</legend>
                    <div class="grid">
                            <div class="formulario__campo"
                                <label class="formulario__label" for="publico1">Publico1</label>
                                <p class="formulario__descripcion publico1" id="publico1">${producto.precio.publico1}</p>
    
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero2">Herrero2</label>
                                <p class="formulario__descripcion herrero2" id="herrero2">${producto.precio.herrero2}</p>
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero3">Herrero3</label>
                                <p class="formulario__descripcion herrero3" id="herrero3">${producto.precio.herrero3} </p>
                            </div>
                            <div class="formulario__campo"
                                <label class="formulario__label" for="herrero4">Herrero4</label>
                                <p class="formulario__descripcion herrero4" id="herrero4">${producto.precio.herrero4}</p>
                            </div>

                            <div class="formulario__campo"
                                <label class="formulario__label" for="cantidad">Cantidad</label>
                                <input class="formulario__input" type="number" min="0" name="cantidad" id="cantidad">
                            </div>
                    </div>
                            <div class="opciones">
                                <button class="btn-verde seleccionar" type="button">Seleccionar</button>
                                <button type="button" class="btn-editar">Subir de Nivel</button>
                                <button class="cerrar-modal" type="button">Cancelar</button>
                            </div> 
                
                </form>`;

                modal.innerHTML = formulario


                setTimeout(() => {
                    const formulario = document.querySelector('.formulario--producto');
                    formulario.classList.add('animar');

                    const inputCantidad = document.querySelector('#cantidad');
                    pedido.productoskilos.forEach(elemento => {
                        if (elemento.id == producto.id) {
                            inputCantidad.value = elemento.cantidad;

                            if (elemento.publico1) {
                                const publico1 = document.querySelector('#publico1');
                                publico1.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero2) {
                                const herrero2 = document.querySelector('#herrero2');
                                herrero2.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero3) {
                                const herrero3 = document.querySelector('#herrero3');
                                herrero3.classList.add('formulario__descripcion--resaltar')
                            }

                            if (elemento.herrero4) {
                                const herrero4 = document.querySelector('#herrero4');
                                herrero4.classList.add('formulario__descripcion--resaltar')
                            }
                        }


                    });

                }, 0);


                let precio = '';
                let publico1 = false;
                let herrero2 = false;
                let herrero3 = false;
                let herrero4 = false;
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

                    const precioPrevio = document.querySelector('.formulario__descripcion--resaltar');
                    if (e.target.classList.contains('publico1')) {


                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.publico1;
                            herrero4 = false;
                            herrero3 = false;
                            herrero2 = false;
                            publico1 = true;
                            document.querySelector('.publico1').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero2')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero2;
                            herrero4 = false;
                            herrero3 = false;
                            herrero2 = true;
                            publico1 = false;
                            document.querySelector('.herrero2').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero3')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero3;
                            herrero4 = false;
                            herrero3 = true;
                            herrero2 = false;
                            publico1 = false;
                            document.querySelector('.herrero3').classList.add('formulario__descripcion--resaltar');
                        }

                    }

                    if (e.target.classList.contains('herrero4')) {

                        if (precioPrevio) {
                            precioPrevio.classList.remove('formulario__descripcion--resaltar');
                            precio = '';
                        } else {
                            precio = producto.precio.herrero4;
                            herrero4 = true;
                            herrero3 = false;
                            herrero2 = false;
                            publico1 = false;
                            document.querySelector('.herrero4').classList.add('formulario__descripcion--resaltar');
                        }

                    }


                    if (e.target.classList.contains('seleccionar')) {
                        const cantidad = document.querySelector('#cantidad').value;


                        const obj = {
                            id: producto.id,
                            nombre: producto.nombre,
                            cantidad: cantidad,
                            precio: precio,
                            publico1: publico1,
                            herrero2: herrero2,
                            herrero3: herrero3,
                            tipo: 'En kg',
                            herrero4: herrero4

                        };

                        let esIgual = false;
                        pedido.productoskilos = pedido.productoskilos.map(elemento => {
                            if (elemento.id == producto.id) {
                                elemento.cantidad = cantidad;
                                elemento.precio = precio;
                                elemento.publico1 = publico1;
                                elemento.herrero2 = herrero2;
                                elemento.herrero3 = herrero3;
                                elemento.herrero4 = herrero4;
                                esIgual = true;
                            }

                            return elemento;
                        })


                        if (esIgual && (!cantidad || !precio)) {
                            Swal.fire({
                                title: '¿Resetear Información?',
                                showCancelButton: true,
                                confirmButtonText: 'Si',
                                cancelButtonText: 'No',
                                icon: 'question'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    pedido.productoskilos = pedido.productoskilos.filter(elemento => elemento.id != producto.id);

                                    const productoSeleccionado = document.querySelector(`[data-id-productokilo='${producto.id}']`);
                                    productoSeleccionado.classList.remove('bloque-producto--seleccionado');


                                    body.classList.remove('pausar');
                                    const formulario = document.querySelector('.formulario--producto');
                                    formulario.classList.add('cerrar');


                                    setTimeout(() => {
                                        modal.remove();
                                    }, 500);

                                    botonesPaginador();
                                }
                            })

                        } else if ((!cantidad || !precio)) {
                            Swal.fire('Debe seleccionar un precio y una cantidad', 'Error', 'error');

                        } else if (!esIgual) {

                            pedido.productoskilos = [...pedido.productoskilos, obj];

                            const productoSeleccionado = document.querySelector(`[data-id-productokilo='${producto.id}']`);
                            productoSeleccionado.classList.add('bloque-producto--seleccionado');


                            body.classList.remove('pausar');
                            const formulario = document.querySelector('.formulario--producto');
                            formulario.classList.add('cerrar');


                            setTimeout(() => {
                                modal.remove();
                            }, 500);
                        } else if (esIgual) {
                            body.classList.remove('pausar');
                            const formulario = document.querySelector('.formulario--producto');
                            formulario.classList.add('cerrar');


                            setTimeout(() => {
                                modal.remove();
                            }, 500);
                        }

                        botonesPaginador();



                    }


                });



                document.querySelector('.dashboard').appendChild(modal);



            }


        }

        function mostrarResumen() {
            const contenedorResumen = document.querySelector('#resumen');
            limpiarHtml(contenedorResumen);

            const contenedorCliente = document.createElement('DIV');
            contenedorCliente.classList.add('resumen__contenedor');

            const headingCliente = document.createElement('H3');
            headingCliente.classList.add('resumen__heading');
            headingCliente.textContent = 'Datos del Cliente';



            const nombre = document.createElement('P');
            nombre.innerHTML = `Nombre: <span>${pedido.nombre} </span>`;
            nombre.classList.add('resumen__parrafo');

            const rfc = document.createElement('p');
            rfc.innerHTML = `RFC: <span>${pedido.rfc} </span>`;
            rfc.classList.add('resumen__parrafo');

            const direccion = document.createElement('P');
            direccion.innerHTML = `Dirección: <span>${pedido.direccion}</span>`;
            direccion.classList.add('resumen__parrafo');

            const ubicacion = document.createElement('p');
            ubicacion.innerHTML = `Ubicación: <span>${pedido.ubicacion} </span>`;
            ubicacion.classList.add('resumen__parrafo');

            const telefono = document.createElement('p');
            telefono.innerHTML = `Telèfono: <span>${pedido.telefono} </span>`;
            telefono.classList.add('resumen__parrafo');

            const credito = document.createElement('p');
            credito.innerHTML = `Crédito: <span>${pedido.credito} </span>`;
            credito.classList.add('resumen__parrafo');

            const cuota = document.createElement('p');
            cuota.innerHTML = `Cuota Consumo: <span>${pedido.cuota} </span>`;
            cuota.classList.add('resumen__parrafo');


            contenedorCliente.appendChild(headingCliente);
            contenedorCliente.appendChild(nombre);
            contenedorCliente.appendChild(rfc);
            contenedorCliente.appendChild(telefono);
            contenedorCliente.appendChild(direccion);
            contenedorCliente.appendChild(ubicacion);
            contenedorCliente.appendChild(credito);
            contenedorCliente.appendChild(cuota);


            const contenedorProductos = document.createElement('DIV');
            contenedorProductos.classList.add('resumen__contenedor');

            const headingProductos = document.createElement('H3');
            headingProductos.classList.add('resumen__heading');
            headingProductos.textContent = 'Productos Solicitados';
            contenedorProductos.appendChild(headingProductos);

            const productosMostrar = [...pedido.productos, ...pedido.productoskilos];




            pedido.total = productosMostrar.reduce((total, elemento) => {

                const nombreProducto = document.createElement('P');
                nombreProducto.classList.add('resumen__parrafo');
                nombreProducto.innerHTML = `Nombre: <span>${elemento.nombre}</span>`;


                const tipo = document.createElement('P');
                tipo.classList.add('resumen__parrafo');
                tipo.innerHTML = `Tipo: <span>${elemento.tipo}</span>`;

                const tipoPrecio = document.createElement('P');
                tipoPrecio.classList.add('resumen__parrafo');

                if (elemento.publico1) {
                    tipoPrecio.innerHTML = `Tipo de precio: <span>${elemento.publico1 ? 'Publico1' : ''}</span>`;

                } else if (elemento.herrero2) {
                    tipoPrecio.innerHTML = `Tipo de precio: <span>${elemento.herrero2 ? 'Herrero2' : ''}</span>`;

                } else if (elemento.herrero3) {
                    tipoPrecio.innerHTML = `Tipo de precio: <span>${elemento.herrero3 ? 'Herrero3' : ''}</span>`;

                } else if (elemento.herrero4) {
                    tipoPrecio.innerHTML = `Tipo de precio: <span>${elemento.herrero4 ? 'Herrero4' : ''}</span>`;

                }


                const precio = document.createElement('P');
                precio.classList.add('resumen__parrafo');
                precio.innerHTML = `Precio: <span>${elemento.precio}</span>`;



                const cantidad = document.createElement('P');
                cantidad.classList.add('resumen__parrafo');
                cantidad.innerHTML = `Cantidad: <span>${elemento.cantidad}</span>`;


                const contenedorProducto = document.createElement('DIV');
                contenedorProducto.classList.add(`resumen__contenedor--producto`);


                contenedorProducto.appendChild(nombreProducto);
                contenedorProducto.appendChild(tipo);
                contenedorProducto.appendChild(tipoPrecio);
                contenedorProducto.appendChild(precio);
                contenedorProducto.appendChild(cantidad);


                contenedorProductos.appendChild(contenedorProducto);

                return total + parseFloat(elemento.precio) * parseFloat(elemento.cantidad);

            }, 0);

            const total = document.createElement('P');
            total.classList.add('resumen__total');
            total.innerHTML = `Total: <span>$${pedido.total}</span>`;


            contenedorProductos.appendChild(total);


            contenedorResumen.appendChild(contenedorCliente);
            contenedorResumen.appendChild(contenedorProductos);


        }

        cargarInputs();

        function validarPedido() {
            const botonEnviar = document.querySelector('#enviar-pedido');
            botonEnviar.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Levantar Pedido?',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        verificarObjeto();

                    }
                })
            })
        }

        function cargarInputs() {


            const inputPagado = document.querySelectorAll('input[name="pagado"]');
            const inputStatus = document.querySelectorAll('input[name="status"]');
            const inputMetodo = document.querySelectorAll('input[name="metodoPago"]');


            inputPagado.forEach(input => input.addEventListener('change', function (e) {
                pedido.pagado = e.target.value;
            }));

            inputStatus.forEach(input => input.addEventListener('change', function (e) {
                pedido.status = e.target.value;
            }));

            inputMetodo.forEach(input => input.addEventListener('change', function (e) {
                pedido.metodoPago = e.target.value;
            }));



        }

        function verificarObjeto() {
            console.log(pedido)
            const inputUsuario = document.querySelector('input[name="usuarios_id"]');
            pedido.usuarios_id = inputUsuario.value;
            if (pedido.pagado == '' || pedido.status == '' || pedido.metodoPago == '') {
                Swal.fire('Debe llenar todos los campos', 'Error', 'error');
            } else {
                levantarPedido();
            }
        }

        async function levantarPedido() {
            const url = '/api/pedidos/levantar';


            const productos = pedido.productos.length > 0 ? JSON.stringify(pedido.productos) : '';
            const productoskilos = pedido.productoskilos.length > 0 ? JSON.stringify(pedido.productoskilos) : '';

            const datos = new FormData();
            datos.append('usuarios_id', pedido.usuarios_id);
            datos.append('cliente', pedido.cliente);
            datos.append('pagado', pedido.pagado);
            datos.append('metodoPago', pedido.metodoPago);
            datos.append('status', pedido.status);
            datos.append('total', pedido.total);
            datos.append('productos', productos);
            datos.append('productoskilos', productoskilos);

            try {

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {
                    Swal.fire('Enviado!', resultado.mensaje, 'success').then(() => {
                        window.location.reload();
                    });
                }

            } catch (error) {
                console.log(error);
                Swal.fire('Ha ocurrido un Error', 'Error', 'error');
            }


        }

        function limpiarHtml(contenedor) {
            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }



    }
})();