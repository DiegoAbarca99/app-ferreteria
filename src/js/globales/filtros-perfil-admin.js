(function () {
    const select = document.querySelector('#filtro-select');
    const buscador = document.querySelector('#filtro-buscador');

    if (select) {
        
        select.addEventListener('input', (e) => {
            const categoria = e.target.value;
            window.location = `?categoria=${categoria}`;
        });

        buscador.addEventListener('click', (e) => {
            e.preventDefault();
            const nombre = e.target.parentElement.querySelector('input').value;
            window.location = `?nombre=${nombre}`;
        })

    }
})();