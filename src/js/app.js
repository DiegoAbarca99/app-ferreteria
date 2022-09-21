//-----------Sidebar------------------------ 

const mobileMenuBtn=document.querySelector('#mobile-menu');
const cerrarMenuBtn=document.querySelector('#cerrar-menu');
const sidebar=document.querySelector('.sidebar');

if(mobileMenuBtn) mobileMenuBtn.addEventListener('click',function(){
    sidebar.classList.add('mostrar');
});

if(cerrarMenuBtn) cerrarMenuBtn.addEventListener('click',function(){
    sidebar.classList.add('ocultar');

    setTimeout(() => {
        sidebar.classList.remove('mostrar');
        sidebar.classList.remove('ocultar');
    }, 1000);
});

//Elimina la clase de mostrar, en un tamaño de tablet y mayores

window.addEventListener('resize',function(){

    const anchoPantalla=document.body.clientWidth;
    if(anchoPantalla >= 768){
        sidebar.classList.remove('mostrar');
    }
});

//-------------------------Select(Crear-perfil)----------------------------

const selectStatus=document.querySelector('#status');

if (selectStatus) selectStatus.addEventListener('input',function(e){
    const status=e.target.value;

    
   
    //Inserta DIV con LABEL Y SELECT para obtener los datos del nivel de acceso del proveedor
    if(status==='1'){

        const contenedorNivel=document.createElement('DIV');
        contenedorNivel.classList.add('campo','existe');
    

        const labelNivel=document.createElement('LABEL');
        labelNivel.textContent='Nivel de Acceso';

        const selectNivel=document.createElement('SELECT');
        selectNivel.name="nivel";

        selectNivel.innerHTML=`
            <option value=0>Regular</option>
            <option value=1>Privilegiado</option>
        `;

        contenedorNivel.appendChild(labelNivel);
        contenedorNivel.appendChild(selectNivel);

        //Inserción en el fieldset definido mediante HTML
        const contenedorCampos=document.querySelector('#campos');
        contenedorCampos.appendChild(contenedorNivel);

       
        
    }else{
         //Corrobora que el contenedorNivel no esté previamente definido para evitar duplicados.
         const contenedorNivelAnterior=document.querySelector('.existe');
         if(contenedorNivelAnterior){
             contenedorNivelAnterior.remove();
         }
    }
});

//---------------------------Muestra alerta al momento de eliminar un usuario-------------------------

const eliminar=document.querySelector('#eliminar');
let id=document.querySelector('#id');
id=id.value;



eliminar.addEventListener('click',function(e){
    e.preventDefault();
    Swal.fire({

        title: '¿Eliminar Perfil?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText:'No'
        }).then((result) => {
            if (result.isConfirmed) {
               eliminarPerfil(id);
            } 
        })

});


async function eliminarPerfil(id) {
    
    const datos=new FormData();
    datos.append('id',id);
    
    try {
        const url="http://localhost:3000/perfiles/eliminar";

        const respuesta=await fetch(url,{
            method:'POST',
            body:datos
        });

        const resultado= await respuesta.json();
           

            if(resultado.resultado){
                swal.fire('Eliminado!',resultado.mensaje,'success');

                setTimeout(() => {
                    window.location.replace("http://localhost:3000/perfiles/index");
                }, 1000);

            } 

    } catch (error) {
        swal.fire('Error!','Ocurrió un error','error');
    }
}