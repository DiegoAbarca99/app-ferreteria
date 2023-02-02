import Swal from "sweetalert2";

export async function agregarElemento(datos, url) {
    try {


        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();


        if (resultado.tipo === 'exito') {
            Swal.fire(resultado.mensaje, 'Operación exitosa', 'success').then(() => {
                window.location.reload();
            });

        } else if (resultado.tipo === 'error') {
            Swal.fire(resultado.mensaje, 'Error!', 'error');
        }




    } catch (error) {
        console.error(error);
        Swal.fire('Ha ocurrido un error!', 'Error!', 'error');
    }

}
