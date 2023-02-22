import Swal from "sweetalert2";

export function mostrarInformacionProducto(producto) {
    const inicio = document.querySelector('#cerrar-menu');
    if (inicio) {
        inicio.scrollIntoView({
            behavior: 'smooth'
        });
    }

    const body = document.querySelector('body');
    body.classList.add('pausar');

    const isPrivilegiado = document.querySelector('#isPrivilegiado').value;

    const modal = document.createElement('DIV');
    modal.classList.add('modal');

    let formulario = '';
    formulario = `
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
                </div>`
    if (isPrivilegiado == 1) {
        formulario +=
            `<div class="formulario__campo"
                            <label class="formulario__label" for= "herrero4" > Mayoreo1</label >
                            <input disabled class="formulario__input " type="text" id="mayoreo1" value="${producto.precio.mayoreo1}">
                        </div >
                        <div class="formulario__campo"
                            <label class="formulario__label" for="herrero4">Mayoreo2</label>
                            <input disabled class="formulario__input" type="text" id="mayoreo2" value="${producto.precio.mayoreo2}">
                        </div > `
    }
    formulario += `</div>
                <div class="opciones">
                    <button class="cerrar-modal" type="button">Aceptar</button>`
    if (isPrivilegiado == 0) formulario += `<button type="button" class="btn-editar subir-nivel">Subir de Nivel</button>`
    formulario += `</div> 
    
    </form>`;

    modal.innerHTML = formulario



    setTimeout(() => {
        const formulario = document.querySelector('.formulario--producto');
        formulario.classList.add('animar');
    }, 0);



    modal.addEventListener('click',async function (e) {
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

        if (e.target.classList.contains('subir-nivel')) {

            const respuesta = await fetch('/solicitarSubirNivel',{method:'POST'});
            const resultado = await respuesta.json();

            if (resultado.tipo === 'exito') {
                Swal.fire(resultado.mensaje, '', 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire(resultado.mensaje, '', 'error'); 

            }



        }


    });



    document.querySelector('.dashboard').appendChild(modal);

}