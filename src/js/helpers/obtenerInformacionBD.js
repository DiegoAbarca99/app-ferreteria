export async function obtenerInformacionBD(url) {
    const respuesta = await fetch(url);
    const resultado = await respuesta.json();

    return resultado;
}