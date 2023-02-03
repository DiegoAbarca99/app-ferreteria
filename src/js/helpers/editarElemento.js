import Swal from "sweetalert2";

export async function editarElemento(datos, url) {
    try {


        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        

        const resultado = await respuesta.json();

        if (resultado.tipo == 'exito') {
            Swal.fire('Exito', resultado.mensaje, 'success').then(() => {
                window.location.reload();
            });
        } else if (resultado.tipo === 'error') {
            Swal.fire(resultado.mensaje, 'Error!', 'error');
        }

    } catch (error) {
        console.error(error);
        Swal.fire('Ha Ocurrido un Error al Actualizar el Registro', 'Error!', 'error');

    }
}