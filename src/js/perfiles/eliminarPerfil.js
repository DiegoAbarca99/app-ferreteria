import Swal from "sweetalert2";
import { eliminarElemento } from "../helpers";

(function () {
    const botonesEliminar = document.querySelectorAll('.eliminar-perfil');
    const botonEliminar = document.querySelector('#eliminar-perfil');

    const url = '/perfiles/eliminar';
    const urlRedireccionar = '/perfiles/index';
    const mensajeError = 'Hay registros asociados en los historicos';

    //Botón ubicado en la página particular del perfil seleccionado
    if (botonEliminar) {
        botonEliminar.addEventListener('click', function (e) {
            e.preventDefault();

            let id = document.querySelector('#id');
            id = id.value;

            Swal.fire({
                title: '¿Eliminar Perfil Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarElemento(id, url, urlRedireccionar, mensajeError);
                }
            })

        });
    }

    if (botonesEliminar.length > 0) {
        botonesEliminar.forEach(boton => boton.addEventListener('click', function (e) {
            e.preventDefault();

            let formulario = boton.parentElement;

            let id = formulario.querySelector('#id');
            id = id.value;

            Swal.fire({
                title: '¿Eliminar Registro Seleccionado?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                icon: 'question'
            }).then((result) => {
                if (result.isConfirmed) {
                    prepararDatos(id);
                    
                }
            })

        }));

        async function prepararDatos(id) {
            await eliminarElemento(id, url, '', mensajeError, true);
        }
    }


})();
