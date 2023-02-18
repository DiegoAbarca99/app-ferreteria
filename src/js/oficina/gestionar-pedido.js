import Swal from 'sweetalert2';

(function () {
    const inputFecha = document.querySelector('#fecha');

    if (inputFecha) {


        const btnArriba = document.querySelector('#arriba');
        btnArriba.addEventListener('click', function () {
            const arriba = document.querySelector('.nombre-pagina');
            arriba.scrollIntoView({
                behavior: 'smooth'
            });
        });

        const btnAbajo = document.querySelector('#abajo');
        btnAbajo.addEventListener('click', function () {
            const abajo = document.querySelector('.abajo');
            abajo.scrollIntoView({
                behavior: 'smooth'
            });
        })



        const btnBuscar = document.querySelector('#buscar-pedido');
        const buscador = document.querySelector('#buscador-usuario');
        const advertencia = document.querySelector('#advertencia');
        const inputTipo = document.querySelectorAll('input[name="tipo"]');
        const inputPagado = document.querySelectorAll('input[name="pagado"]');

        let usuario = '';
        let fecha = '';
        let usuarioInvalido;
        let tipo = '';
        let pagado = '';

        let pedidos = [];

        inputPagado.forEach(input => {
            input.addEventListener('input', function (e) {
                pagado = e.target.value;
            })
        });


        inputTipo.forEach(input => {
            input.addEventListener('input', function (e) {
                tipo = e.target.value;
            });

        });



        buscador.addEventListener('input', function (e) {
            if (e.target.value.trim().length < 5 && e.target.value.trim().length > 0) {
                advertencia.textContent = 'Debe de ingresar minimo 4 carécteres';
                usuarioInvalido = true;
            } else {
                advertencia.textContent = '';
                usuarioInvalido = false;
            }
        })

        btnBuscar.addEventListener('click', async function (e) {
            e.preventDefault();
            fecha = inputFecha.value;
            usuario = buscador.value;


            if (usuarioInvalido) {
                Swal.fire('El usuario ingresado no es valido!', '', 'error');
            } else if (!pagado) {

                Swal.fire('Debe especificar el tipo de pago!', '', 'error');

            } else if (!tipo) {
                Swal.fire('Debe especificar el tipo de filtro!', '', 'error');
            } else {
                await obtenerPedidos();
                obtenerResumen();
            }

        });

        async function obtenerPedidos() {
            try {
                const url = `/api/pedidos/listar?usuario=${usuario}&fecha=${fecha}&tipo=${tipo}&pagado=${pagado}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();

                if (resultado.length == 0) {
                    Swal.fire('No hay Ningún pedido asociado!', 'Error', 'error').then(() => {
                        window.location.reload();
                    });
                } else {

                    pedidos = formatearPedidos(resultado);
                    mostrarPedidos();

                }


            } catch (error) {
                console.log(error);
                Swal.fire('Ha ocurrido un error!', 'Error', 'error').then(() => {
                    window.location.reload();
                });

            }



        }

        function formatearPedidos(resultado) {

            let pedidos = [...resultado[0], ...resultado[1]];

            pedidos.sort();
            pedidos.sort(((a, b) => b.id - a.id));
            return pedidos;
        }

        function mostrarPedidos() {

            const contenedorPedidos = document.querySelector('#pedidos');
            limpiarHtml(contenedorPedidos);



            let i = 0;
            console.log(pedidos)

            while (i < pedidos.length) {

                const contenedorPedido = document.createElement('DIV');
                contenedorPedido.classList.add('pedido');

                const contenedorProductos = document.createElement('DIV');
                contenedorProductos.classList.add('pedido__productos');


                const headingPrincipal = document.createElement('H3');
                headingPrincipal.innerHTML = `${pedidos[i].folio}`;
                headingPrincipal.classList.add('pedido__heading--principal');

                //---------Usuario---------------
                const headingUsuario = document.createElement('H4');
                headingUsuario.classList.add('pedido__heading');
                headingUsuario.textContent = 'Información del Proveedor';

                const usuario = document.createElement('P');
                usuario.innerHTML = `Usuario: <span>${pedidos[i].usuario}</span>`;
                usuario.classList.add('pedido__parrafo');

                const nombre = document.createElement('P');
                nombre.innerHTML = `Nombre Completo: <span>${pedidos[i].nombre}</span>`;
                nombre.classList.add('pedido__parrafo');

                const celular = document.createElement('P');
                celular.innerHTML = `Teléfono: <span>${pedidos[i].celular}</span>`;
                celular.classList.add('pedido__parrafo');

                const surcursal = document.createElement('P');
                surcursal.innerHTML = `Sucursal: <span>${pedidos[i].sucursal}</span>`;
                surcursal.classList.add('pedido__parrafo');



                //----------Cliente-----------------
                const headingCliente = document.createElement('H4');
                headingCliente.innerHTML = 'Información del Cliente';
                headingCliente.classList.add('pedido__heading');

                const cliente = document.createElement('P');
                cliente.innerHTML = `Cliente: <span>${pedidos[i].cliente}</span>`;
                cliente.classList.add('pedido__parrafo');

                const curp = document.createElement('P');
                curp.innerHTML = `Curp: <span>${pedidos[i].curp}</span>`;
                curp.classList.add('pedido__parrafo');

                const credito = document.createElement('P');
                credito.innerHTML = `Crédito: <span>${pedidos[i].credito == 1 ? 'Si' : 'No'}</span>`;
                credito.classList.add('pedido__parrafo');
                if (pedidos[i].credito == 1) {
                    credito.classList.add('pedido__parrafo--alerta');
                } else {
                    credito.classList.add('pedido__parrafo--success');
                }


                const cuota = document.createElement('P');
                cuota.innerHTML = `Cuota Consumo: <span>${pedidos[i].cuota}</span>`;
                cuota.classList.add('pedido__parrafo');
                if (pedidos[i].pagado == 1) cuota.classList.add('pedido__parrafo--success');
                else if (pedidos[i].pagado == 0) cuota.classList.add('pedido__parrafo--alerta');

                const telefono = document.createElement('P');
                telefono.innerHTML = `Teléfono: <span>${pedidos[i].telefono}</span>`;
                telefono.classList.add('pedido__parrafo');

                const ubicacion = document.createElement('P');
                ubicacion.innerHTML = `Ubicación: <span>${pedidos[i].ubicacion}</span>`;
                ubicacion.classList.add('pedido__parrafo');

                const direccion = document.createElement('P');
                direccion.innerHTML = `Dirección: <span>${pedidos[i].direccion}</span>`;
                direccion.classList.add('pedido__parrafo');



                //--------------Pedidos----------------------

                const headingPedido = document.createElement('H4');
                headingPedido.innerHTML = "Datos del pedido";
                headingPedido.classList.add('pedido__heading');

                let deshabilitar;
                const pagado = document.createElement('BUTTON');
                pagado.dataset.idPagado = i;
                if (pedidos[i].pagado == 1) {
                    pagado.textContent = 'Pagado';
                    pagado.classList.add('btn-verde');
                    deshabilitar = false;
                } else {
                    pagado.textContent = 'No Pagado';
                    pagado.classList.add('btn-eliminar-disabled');
                    deshabilitar = true;
                }

                pagado.onclick = (e) => {

                    cambiarPagado(parseInt(e.target.dataset.idPagado), deshabilitar);
                }


                const metodoPago = document.createElement('BUTTON');
                if (pedidos[i].pagado == 1) {
                    metodoPago.dataset.idPago = i;
                    metodoPago.textContent = `${pedidos[i].metodoPago == 1 ? 'Efectivo' : 'Digital'}`;
                    metodoPago.classList.add(`${pedidos[i].metodoPago == 1 ? 'btn-verde' : 'btn-editar'}`);
                    metodoPago.onclick = (e) => {
                        cambiarMetodoPago(e.target.dataset.idPago);
                    }
                }

                const abono = document.createElement('FORM');
                abono.dataset.idAbono = i;
                abono.classList.add('flex-centro');
                if (pedidos[i].pagado == 0) {
                    abono.innerHTML = `<p class= "pedido__parrafo"> Abono: </p> <input type="number" step="any" class="input-escondido" value="${pedidos[i].abono}">`;
                    abono.onsubmit = (e) => {
                        e.preventDefault();
                        const nuevoAbono = e.target.querySelector('.input-escondido').value;

                        actualizarAbono(parseInt(e.target.dataset.idAbono), parseFloat(nuevoAbono));

                    }
                }




                const status = document.createElement('BUTTON');
                status.dataset.id = i;
                if (pedidos[i].status == 2) {
                    status.textContent = 'Entregado';
                    status.classList.add('btn-verde');
                } else if (pedidos[i].status == 1) {
                    status.textContent = 'Enviado';
                    status.classList.add('btn-editar');
                } else if (pedidos[i].status == 0) {
                    status.textContent = 'Proceso de Envio';
                    status.classList.add('btn-eliminar',);
                }

                status.onclick = (e) => {
                    cambiarEstado(parseInt(e.target.dataset.id));
                };


                const hora = document.createElement('P');
                hora.innerHTML = `Hora: <span>${pedidos[i].fecha.split(' ')[1]}</span>`;
                hora.classList.add('pedido__parrafo');

                const cuotaAplicada = document.createElement('P');
                cuotaAplicada.innerHTML = `Cuota Aplicada: <span>${pedidos[i].cuotaAplicada}</span>`;
                cuotaAplicada.classList.add('pedido__parrafo--total');


                const total = document.createElement('P');
                if (pedidos[i].pagado == 0 && pedidos[i].abono > 0) total.innerHTML = `Total: <span>$${parseFloat(pedidos[i].total) - parseFloat(pedidos[i].abono)}</span>`;
                else total.innerHTML = `Total: <span>$${pedidos[i].total}</span>`;
                total.classList.add('pedido__parrafo--total');




                const headingProducto = document.createElement('P');
                headingProducto.innerHTML = "Productos Solicitados";
                headingProducto.classList.add('pedido__heading');

                const contenedorUsuario = document.createElement('DIV');
                contenedorUsuario.classList.add('pedido__contenedor');

                contenedorUsuario.appendChild(headingPrincipal);
                contenedorUsuario.appendChild(headingUsuario);
                contenedorUsuario.appendChild(usuario);
                contenedorUsuario.appendChild(nombre);
                contenedorUsuario.appendChild(celular);
                contenedorUsuario.appendChild(surcursal);


                const contenedorCliente = document.createElement('DIV');
                contenedorCliente.classList.add('pedido__contenedor');


                contenedorCliente.appendChild(headingCliente);
                contenedorCliente.appendChild(cliente);
                contenedorCliente.appendChild(curp);
                contenedorCliente.appendChild(credito);
                contenedorCliente.appendChild(cuota);
                contenedorCliente.appendChild(telefono);
                contenedorCliente.appendChild(ubicacion);
                contenedorCliente.appendChild(direccion);

                const contenedorPeticiones = document.createElement('DIV');
                contenedorPeticiones.classList.add('pedido__contenedor');


                contenedorPeticiones.appendChild(headingPedido);
                contenedorPeticiones.appendChild(hora);
                if (pedidos[i].pagado == 1) contenedorPeticiones.appendChild(metodoPago);
                if (pedidos[i].pagado == 0) contenedorPeticiones.appendChild(abono);
                contenedorPeticiones.appendChild(pagado);
                contenedorPeticiones.appendChild(status);
                contenedorPeticiones.appendChild(cuotaAplicada);
                contenedorPeticiones.appendChild(total);



                contenedorPedido.appendChild(contenedorUsuario);
                contenedorPedido.appendChild(contenedorCliente);
                contenedorPedido.appendChild(contenedorPeticiones);


                //--------------------Productos---------------------------------
                const headingProductos = document.createElement('H4');
                headingProductos.classList.add('pedido__heading');
                headingProductos.textContent = 'Listado de Productos';

                contenedorProductos.appendChild(headingProductos);


                let j = i;
                While: while (true) {

                    if (pedidos[j] == undefined) break While;


                    const producto = document.createElement('P');
                    producto.innerHTML = `Producto: <span>${pedidos[j].producto}</span>`;
                    producto.classList.add('pedido__parrafo');

                    const cantidad = document.createElement('P');
                    cantidad.innerHTML = `Cantidad: <span>${pedidos[j].cantidad}</span>`;
                    cantidad.classList.add('pedido__parrafo');

                    const tipo = document.createElement('P');
                    tipo.innerHTML = `Tipo Precio: <span>${pedidos[j].tipo}</span>`;
                    tipo.classList.add('pedido__parrafo');

                    const precio = document.createElement('P');
                    precio.innerHTML = `Precio: <span>$${pedidos[j].precio}</span>`;
                    precio.classList.add('pedido__parrafo');


                    const contenedorProducto = document.createElement('DIV');
                    contenedorProducto.classList.add('pedido__producto');


                    contenedorProducto.appendChild(producto);
                    contenedorProducto.appendChild(cantidad);
                    contenedorProducto.appendChild(tipo);
                    contenedorProducto.appendChild(precio);


                    contenedorProductos.appendChild(contenedorProducto);





                    if (pedidos[j + 1] == undefined || (pedidos[j].id != pedidos[j + 1].id)) {

                        i = j + 1;
                        break While;
                    } else {
                        j++;
                    }

                }




                contenedorPedido.appendChild(contenedorProductos);
                contenedorPedidos.appendChild(contenedorPedido);




            }

        }

        async function cambiarMetodoPago(id) {
            try {
                const url = '/api/pedidos/metodo-pago';

                const datos = new FormData();
                datos.append('metodoPago', pedidos[id].metodoPago);
                datos.append('id', pedidos[id].id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {


                    pedidos = pedidos.map((pedido, index) => {
                        if (pedido.id == pedidos[id].id) {
                            pedidos[index].metodoPago = !pedidos[id].metodoPago;
                        }
                        return pedido;
                    })

                    mostrarPedidos();



                } else {
                    Swal.fire('Ha ocurrido un error', 'Error!', 'error');
                }

            } catch (error) {
                console.log();
                Swal.fire('Ha ocurrido un error', 'Error!', 'error');
            }
        }

        async function actualizarAbono(id, abono) {

            if (abono > parseFloat(pedidos[id].total)) {
                Swal.fire('El Abono sobrepasa la deuda!', 'Error!', 'error');
                return;
            }



            try {
                const url = '/api/pedidos/abono';

                const datos = new FormData();
                datos.append('abono', abono);
                datos.append('id', pedidos[id].id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {


                    pedidos = pedidos.map((pedido, index) => {
                        if (pedido.id == pedidos[id].id) {
                            pedidos[index].abono = abono;
                        }
                        return pedido;
                    })

                    mostrarPedidos();
                    obtenerResumen();

                    cambiarPagado(id, false, true);



                } else {
                    Swal.fire('Ha ocurrido un error', 'Error!', 'error');
                }

            } catch (error) {
                console.log();
                Swal.fire('Ha ocurrido un error', 'Error!', 'error');
            }


        }



        async function cambiarPagado(id, deshabilitar = false, isByAbono = false) {

            if (deshabilitar) return;


            if (isByAbono && (pedidos[id].abono != pedidos[id].total)) return;





            try {

                const url = '/api/pedidos/pagado';

                const datos = new FormData();
                if (isByAbono) datos.append('pagado', 1);
                else datos.append('pagado', 0);
                datos.append('id', pedidos[id].id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {

                    if (isByAbono) {
                        pedidos = pedidos.map((pedido, index) => {
                            if (pedido.id == pedidos[id].id) {
                                pedidos[index].pagado = 1;
                            }
                            return pedido;
                        })

                    } else {
                        pedidos = pedidos.map((pedido, index) => {
                            if (pedido.id == pedidos[id].id) {
                                pedidos[index].pagado = 0;
                            }
                            return pedido;
                        })


                    }


                    const salida = comprobarCreditoCliente(pedidos[id].curp);

                    if (salida) {
                        await obtenerPedidos();
                        obtenerResumen();
                    }





                } else {
                    Swal.fire('Ha ocurrido un error', 'Error!', 'error');
                }

            } catch (error) {
                console.log();
                Swal.fire('Ha ocurrido un error', 'Error!', 'error');
            }





        }

        async function comprobarCreditoCliente(curp) {

            let credito;

            if (pedidos.some(pedido => pedido.pagado == 0 && pedido.curp == curp)) {
                credito = 1;
            } else {
                credito = 0
            }

            try {
                const url = '/api/pedidos/credito';
                const datos = new FormData();
                datos.append('credito', credito);
                datos.append('curp', curp);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();
                console.log(resultado)
                if (resultado.tipo == 'exito') {

                    if (resultado.mensaje) {

                        Swal.fire(resultado.mensaje, '', 'warning');

                        await obtenerPedidos();
                        obtenerResumen();

                        return false;


                    }

                    return true;

                } else {
                    Swal.fire('Ha ocurrido un error', 'Error!', 'error');
                }
            } catch (error) {
                console.log();
                Swal.fire('Ha ocurrido un error', 'Error!', 'error');
            }




        }
        async function cambiarEstado(id) {
            let status;

            if (pedidos[id].status == 0) {
                status = 1;
            } else if (pedidos[id].status == 1) {
                status = 2;
            } else if (pedidos[id].status == 2) {
                status = 0;
            }

            try {
                const url = '/api/pedidos/estado';

                const datos = new FormData();
                datos.append('status', status);
                datos.append('id', pedidos[id].id);

                const respuesta = await fetch(url, {
                    method: 'POST',
                    body: datos
                });

                const resultado = await respuesta.json();

                if (resultado.tipo == 'exito') {


                    pedidos[id].status = status;

                    mostrarPedidos();



                } else {
                    Swal.fire('Ha ocurrido un error', 'Error!', 'error');
                }

            } catch (error) {
                console.log();
                Swal.fire('Ha ocurrido un error', 'Error!', 'error');
            }




        }


        function obtenerResumen() {
            if (pedidos.length == 0) return;

            let cantidadNeta = 0;
            pedidos.forEach(pedido => cantidadNeta += parseInt(pedido.cantidad));

            let gananciaTotal = 0;
            let cuotaValida = true;
            pedidos.forEach((pedido, index) => {
                gananciaTotal += (parseFloat(pedido.precio) * parseInt(pedido.cantidad));
                if (pedidos[index - 1] && (pedido.folio == pedidos[index - 1].folio)) cuotaValida = false;
                else cuotaValida = true;
                if (cuotaValida) {
                    gananciaTotal += parseFloat(pedido.cuotaAplicada);

                    if (pedido.pagado == 0) gananciaTotal -= pedido.abono;
                }

            });

            let numeroPedidos = 0;
            const ids = pedidos.map((pedido) => pedido.id);
            const resultado = ids.filter((id, index) => {
                return ids.indexOf(id) === index;
            })

            resultado.forEach(() => numeroPedidos++);

            mostrarResumen(cantidadNeta, gananciaTotal, numeroPedidos);
        }

        function mostrarResumen(cantidadNeta, gananciaTotal, numeroPedidos) {
            const contenedorResumen = document.querySelector('#resumen-pedidos');
            contenedorResumen.classList.add('resumen-pedidos')
            limpiarHtml(contenedorResumen);


            const headingResumen = document.createElement('H3');
            headingResumen.classList.add('resumen-pedidos__heading');
            headingResumen.textContent = 'Datos Estadísticos';

            const cantidadTotal = document.createElement('P');
            cantidadTotal.classList.add('resumen-pedidos__parrafo');
            cantidadTotal.innerHTML = `Cantidad de Productos: <span>${cantidadNeta}</span>`;

            const numeroRegistros = document.createElement('P');
            numeroRegistros.classList.add('resumen-pedidos__parrafo');
            numeroRegistros.innerHTML = `Número de Pedidos: <span>${numeroPedidos}</span>`;

            const ganancia = document.createElement('P');
            ganancia.classList.add('resumen-pedidos__parrafo');
            if (pagado == 1) {
                ganancia.classList.add('resumen-pedidos__parrafo--success');
                ganancia.innerHTML = `Ganancia Total: <span>$${gananciaTotal}</span>`;
            } else {
                ganancia.classList.add('resumen-pedidos__parrafo--alerta');
                ganancia.innerHTML = `Deuda Total: <span>$${gananciaTotal}</span>`;
            }



            const contenedorInformacion = document.createElement('DIV');
            contenedorInformacion.classList.add('resumen-pedidos__contenedor');

            contenedorInformacion.appendChild(numeroRegistros);
            contenedorInformacion.appendChild(cantidadTotal);
            contenedorInformacion.appendChild(ganancia);

            contenedorResumen.appendChild(headingResumen);
            contenedorResumen.appendChild(contenedorInformacion);


        }

        function limpiarHtml(contenedor) {
            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }
    }
})();