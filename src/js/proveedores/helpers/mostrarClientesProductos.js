import { limpiarHtml } from "../../helpers";
import { mostrarInformacionProducto } from "./mostrarInformacionProducto";

export function mostrarClientesProductos(arregloInformacion, contenedorInformacion, editar = false) {

    limpiarHtml(contenedorInformacion);

    arregloInformacion.map(informacion => {

        const bloqueInformacion = document.createElement('DIV');
        bloqueInformacion.classList.add('bloque-producto');


        const heading = document.createElement('H3');
        heading.classList.add('bloque-producto__heading');
        heading.innerHTML = `<span class="bloque-producto__heading--resaltar"> Nombre:</span > ${informacion.nombre}`;

        bloqueInformacion.appendChild(heading);

        bloqueInformacion.onclick = function () {
            if (editar) window.location.href = `/proveedor/clientes/actualizar?id=${informacion.id}`;
            else mostrarInformacionProducto(informacion);

        };

        contenedorInformacion.appendChild(bloqueInformacion);


    });


}