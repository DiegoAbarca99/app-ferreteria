(function () {
    const codigoPostal = document.querySelector('#codigoPostal');

    if (codigoPostal) {

        const inputEstado = document.querySelector('#estado');
        const inputMunicipio = document.querySelector('#municipio');

        codigoPostal.addEventListener('input', function (e) {


            if (e.target.value.length == 5) {
                conectarApi(e.target.value);
            } else {
                inputEstado.value = '';
                inputMunicipio.value = '';
            }


        });

        async function conectarApi(cp) {

            try {


                const options = {
                    method: 'GET',
                    headers: {
                        'X-RapidAPI-Key': '37d48d392bmsh7e9a82bb11c5b13p11f781jsn82351ff00a29',
                        'X-RapidAPI-Host': 'codigo-postales-mexico-gratis.p.rapidapi.com'
                    }
                };

                const respuesta = await fetch(`https://codigo-postales-mexico-gratis.p.rapidapi.com/code_postal/consulta/cp.php?cp=${cp}`, options)
                const resultado = await respuesta.json();
                const { response } = resultado;
                const { estado, municipio } = response;

                inputEstado.value = estado;
                inputMunicipio.value = municipio;

            } catch (error) {
                console.log(error);
            }


        }
    }

})();