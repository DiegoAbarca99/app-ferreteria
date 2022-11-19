(function () {
    
    const sidebar = document.querySelector('.sidebar');

    if (sidebar) {


        sideBar();
        resizeSideBar();




        function sideBar() {
            

            const mobileMenuBtn = document.querySelector('#mobile-menu');
            const cerrarMenuBtn = document.querySelector('#cerrar-menu');
            const body=document.querySelector('body');

            if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', function () {
                sidebar.classList.add('sidebar--mostrar');
                body.classList.add('pausar');
                
            });

            if (cerrarMenuBtn) cerrarMenuBtn.addEventListener('click', function () {
                sidebar.classList.add('sidebar--ocultar');

                setTimeout(() => {
                    sidebar.classList.remove('sidebar--mostrar');
                    sidebar.classList.remove('sidebar--ocultar');
                    body.classList.remove('pausar');
                }, 1000);
            });

        }

        function resizeSideBar() {
            window.addEventListener('resize', function () {

                const anchoPantalla = document.body.clientWidth;
                if (anchoPantalla >= 768) {
                    sidebar.classList.remove('sidebar--mostrar');
                }
            });
        }

    }


})();