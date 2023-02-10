import Swal from "sweetalert2";

export async function guardarCambioBD(datos, url, urlRedirrecionar = '') {
    try {


        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();


        if (resultado.tipo === 'exito') {
            Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                if (urlRedirrecionar !== '') window.location.href = urlRedirrecionar
                else window.location.reload();
            });

        } else if (resultado.tipo === 'error') {

            Swal.fire(resultado.mensaje, 'Error!', 'error');

        } else if (resultado.tipo === 'warning') {

            Swal.fire(resultado.mensaje, '', 'warning').then(() => {
                if (urlRedirrecionar !== '') window.location.href = urlRedirrecionar
                else window.location.reload();
            });
        }



    } catch (error) {
        console.error(error);
        Swal.fire('Ha ocurrido un error!', 'Error!', 'error');
    }

}
