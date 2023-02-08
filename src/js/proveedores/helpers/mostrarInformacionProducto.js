export function mostrarInformacionProducto(producto) {
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