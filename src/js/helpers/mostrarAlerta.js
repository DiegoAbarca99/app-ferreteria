 export function mostrarAlerta(mensaje, tipo, referencia) {

    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }


    const alerta = document.createElement('DIV');
    alerta.classList.add('alerta', tipo);
    alerta.textContent = mensaje;


    referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);


    setTimeout(() => {
        alerta.remove();
    }, 3000);
}