<?php include_once __DIR__ . '/../templates/header-dashboard.php'; ?>
<div class="contenedor">

    <div id="pedido">
        <div class="seccion" id="paso-1">

            <h3 class="resaltar-texto descripcion-pagina no-margin">Eliga a un Cliente</h2>

                <div class="filtro">

                    <select class="filtro__select" id="select-municipio">
                        <option value="" selected disabled>--Seleccionar Municipio--</option>
                        <option value="">Seleccionar Todas</option>
                        <?php foreach ($municipios as $municipio) { ?>
                            <option value="<?php echo $municipio->id ?>"><?php echo $municipio->nombre; ?></option>
                        <?php } ?>
                    </select>




                    <form class="filtro__buscador" id="buscador-cliente">
                        <input id="buscar-cliente" type="text" class="filtro__input" placeholder="Buscar por Nombre">
                        <input type="submit" class="filtro__submit" value="Buscar">

                    </form>


                </div>

                <div id="clientes" class="bloques-proveedores"></div>

        </div>

        <div class="seccion" id="paso-2">
            <h3 class="resaltar-texto descripcion-pagina no-margin">Eliga los productos</h2>
                <div class="filtro">

                    <select class="filtro__select" id="select-producto">
                        <option value="" selected disabled>--Seleccionar Categoria--</option>
                        <option value="">Seleccionar Todas</option>
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre; ?></option>
                        <?php } ?>
                    </select>

                    <form class="filtro__buscador" id="buscador-producto">
                        <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
                        <input type="submit" class="filtro__submit" value="Buscar">

                    </form>


                    <a class="btn-verde" id="precios-kilos">
                        <i class="fa-solid fa-arrow-right"></i> Ver precios en kilos
                    </a>

                </div>

                <div id="productos" class="bloques-proveedores"></div>

        </div>

        <div class="seccion" id="seccion-kilos">
            <h3 class="resaltar-texto descripcion-pagina no-margin">Eliga los productos (Precios en Kg)</h2>


                <div class="filtro">

                    <a class="btn-regresar" id="precios-comerciales">
                        <i class="fa-solid fa-arrow-left"></i> Regresar
                    </a>

                    <form class="filtro__buscador" id="buscador-producto-kilo">
                        <input type="text" class="filtro__input" placeholder="Buscar por Nombre">
                        <input type="submit" class="filtro__submit" value="Buscar">

                    </form>




                </div>

                <div id="productos-kilos" class="bloques-proveedores"></div>
        </div>

        <div class="seccion" id="paso-3">
            <h3 class="resaltar-texto descripcion-pagina no-margin">Resumen</h2>
                <div class="resumen contenedor-sm" id='resumen'></div>
        </div>

        <div class="seccion" id="paso-4">
            <h3 class="resaltar-texto descripcion-pagina no-margin">Información Extra</h2>

                <form class="formulario mt-3 contenedor-sm">
                    <div class="formulario__contenedor-campos">
                        <div class="formulario__campo">
                            <div class="flex-centro-col">
                                <label for="pagado" class="text-dark-heading">Pagado:</label>
                                <div class="formulario__contenedor--radios">
                                    <div class="formulario__radio">
                                        <label for="si" class="text-dark">Si</label>
                                        <input type="radio" name="pagado" value="1" id="si">
                                    </div>

                                    <div class="formulario__radio">
                                        <label for="no" class="text-dark">No</label>
                                        <input type="radio" name="pagado" value="0" id="no">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="formulario__campo">

                            <div class="flex-centro-col">
                                <label for="pagado" class="text-dark-heading">Método de pago:</label>
                                <div class="formulario__radio no-margin">
                                    <label for="efectivo" class="text-dark">Efectivo</label>
                                    <input type="radio" name="metodoPago" value="1" id="efectivo">
                                </div>

                                <div class="formulario__radio no-margin">
                                    <label for="transferencia" class="text-dark">Transferencia</label>
                                    <input type="radio" name="metodoPago" value="0" id="transferencia">
                                </div>

                            </div>

                        </div>

                        <div class="formulario__campo--extender formulario__campo ">

                            <div class="flex-centro-col">
                                <label for="status" class="text-dark-heading">Estado:</label>

                                <div class="formulario__radio no-margin">
                                    <label for="entregado" class="text-dark">Entregado</label>
                                    <input type="radio" name="status" value="2" id="entregado">
                                </div>

                                <div class="formulario__radio no-margin">
                                    <label for="enviado" class="text-dark">Enviado</label>
                                    <input type="radio" name="status" value="1" id="enviado">
                                </div>

                                <div class="formulario__radio no-margin">
                                    <label for="envio" class="text-dark">Proceso de Envio</label>
                                    <input type="radio" name="status" value="0" id="envio">
                                </div>

                                <input type="hidden" name="usuarios_id" value="<?php echo $_SESSION['id']; ?>">
                            </div>


                        </div>
                    </div>

                    <div class="flex-centro mt-4">
                        <input type="submit" class="btn btn-verde w-auto" id="enviar-pedido" value="Levantar Pedido">
                    </div>
                </form>


        </div>

        <div class="flex-centro mt-2">
            <button id="anterior" class="btn btn-paginador">
                <i class="fa-solid fa-arrow-left"></i> Anterior
            </button>

            <button id="siguiente" class="btn btn-paginador">
                Siguiente <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </div>



    <?php include_once __DIR__ . '/../templates/footer-dashboard.php' ?>