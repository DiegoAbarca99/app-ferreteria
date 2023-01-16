(function () {
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

                const heading = document.createElement('H3');
                heading.classList.add('bloque-producto__heading');
                heading.innerHTML = `<span class="bloque-producto__heading--resaltar">Nombre:</span> ${cliente.nombre}`;

                bloqueCliente.appendChild(heading);

                bloqueCliente.onclick = function () {
                    window.location.href = `/proveedor/clientes/actualizar?id=${cliente.id}`;
                };

                contenedorClientes.appendChild(bloqueCliente);


            });


        }

        function limpiarHtml(contenedor) {
            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }




    }
})();