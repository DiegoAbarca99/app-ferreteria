import Swal from "sweetalert2";

export async function eliminarElemento(id, url, urlRedireccionar, mensajeError, refrescar = false) {

    try {

        if (!id) {
            Swal.fire(`No Hay Ningún Elemento Seleccionado`, 'Error!', 'error');
            return;
        }

        const datos = new FormData();
        datos.append('id', id);

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.tipo === 'exito') {
            Swal.fire(resultado.mensaje, 'Eliminado!', 'success').then(() => {
                if (refrescar) window.location.reload();
                else window.location.href = urlRedireccionar;

            });

        } else if (resultado.tipo === 'error') {
            Swal.fire(resultado.mensaje, 'Error!', 'error');
        }

    } catch (error) {
        console.error(error);
        Swal.fire(mensajeError, 'Error!', 'error');
    }
}


