
(function () {

    const status = document.querySelector('#status');
    if (status) {


        //En caso de que se actualize un perfil, se obtienen el status y nivel de acceso previamente definidos.
        let statusValue = '';
        statusValue = status.value;
        if (status.value === '2') mostrarStatus();

        status.addEventListener('input', seleccionarStatus);

        function seleccionarStatus(e) {

            const contenedorPrevioNivelAcceso = document.querySelector('.existe');
            if (contenedorPrevioNivelAcceso)  contenedorPrevioNivelAcceso.remove();

            statusValue = e.target.value;
            if (statusValue === '2') mostrarStatus();



        }

        //Se ejecuta para mostrar el select del nivel de acceso del proveedor
        function mostrarStatus() {

            //Valor predefinido
            const nivelAcessoHidden = document.querySelector('#nivel-hidden');
            const nivelAccesoValue = nivelAcessoHidden.value;


            const contenedorNivelAcceso = document.createElement('DIV');
            contenedorNivelAcceso.classList.add('formulario__campo', 'existe');


            const labelNivelAcceso = document.createElement('LABEL');
            labelNivelAcceso.textContent = 'Nivel de Acceso';
            labelNivelAcceso.classList.add('formulario__label');

            const selectNivelAcceso = document.createElement('SELECT');
            selectNivelAcceso.name = "nivel";
            selectNivelAcceso.classList.add('formulario__input', 'formulario__input--select');

            selectNivelAcceso.innerHTML = `
                <option value=0 ${nivelAccesoValue == 0 ? 'selected' : ''}>Regular</option>
                <option value=1 ${nivelAccesoValue == 1 ? 'selected' : ''}>Privilegiado</option>`;

            contenedorNivelAcceso.appendChild(labelNivelAcceso);
            contenedorNivelAcceso.appendChild(selectNivelAcceso);


            const contenedorCampos = document.querySelector('#campos');
            contenedorCampos.appendChild(contenedorNivelAcceso);


        }

    }




})();