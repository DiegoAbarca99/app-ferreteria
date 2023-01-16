(function () {

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
                            <label class="formulario__label" for="valor">Publico1</label>
                            <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${producto.precio.publico1}">

                        </div>
                        <div class="formulario__campo"
                            <label class="formulario__label" for="valor">Herrero2</label>
                            <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${producto.precio.herrero2}">
                        </div>
                        <div class="formulario__campo"
                            <label class="formulario__label" for="valor">Herrero3</label>
                            <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${producto.precio.herrero3}">
                        </div>
                        <div class="formulario__campo"
                            <label class="formulario__label" for="valor">Herrero4</label>
                            <input disabled class="formulario__input" type="text" name="valor" id="valor" value="${producto.precio.herrero4}">
                        </div>
                </div>
                        <div class="opciones">
                            <button class="cerrar-modal" type="button">Aceptar</button>
                            <input type="submit" class="btn-verde" value="Subir de Nivel">
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


            });



            document.querySelector('.dashboard').appendChild(modal);

        }

        function limpiarHtml(contenedor) {
            while (contenedor.firstChild) {
                contenedor.removeChild(contenedor.firstChild);
            }
        }

    }



})();