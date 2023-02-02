export function mostrarFormulario(mensajeLabel, mensajeLegend, previousValue) {

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
    <form class="formulario formulario-animar">

        <legend>${mensajeLegend}</legend>
        <div class="formulario__campo"
            <label class="formulario__label" for="valor">${mensajeLabel}</label>
            <input class="formulario__input" type="text" name="valor" id="valor" value="${previousValue}">
        </div>
         <div class="opciones">
            <input type="submit" class="submit-nuevo-valor" value="Agregar">
            <button class="cerrar-modal" type="button">Cancelar </button>
        </div>
    </form>`;

    modal.innerHTML = formulario



    setTimeout(() => {
        const formulario = document.querySelector('.formulario-animar');
        formulario.classList.add('animar');
    }, 0);

    return modal;
    
}