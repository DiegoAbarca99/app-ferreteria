<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <div class="flex-izquierda">
        <a class="btn-regresar" href="/admin/producto-comercial">
            <i class="fa-solid fa-arrow-left"></i> Regresar</a>
    </div>
    <form class="formulario ">


        <fieldset class="formulario__fieldset fieldset-grid">
            <legend class="formulario__legend">Datos del producto</legend>

            <div>
                <div class="formulario__campo">
                    <label class="formulario__label" for="nombre">Nombre del Producto</label>
                    <input disabled class="formulario__input" type="text" name="nombre" id="nombre" value="<?php echo s($producto->nombre) ?>">
                </div>

                <p class="formulario__descripcion">Este es el costo del producto <span class="resaltar-texto">sin contemplar los impuestos.</span></p>
                <div class="formulario__campo">
                    <label class="formulario__label" for="costo">Costo Base</label>
                    <input disabled class="formulario__input" type="number" step="any" min="0" name="costo" id="costo" placeholder="EJ. 5" value="<?php echo s($producto->costo) ?>">
                </div>

                <p class="formulario__descripcion">Este es el costo del producto <span class="resaltar-texto">contemplando los impuestos.</span></p>
                <div class="formulario__campo">
                    <label class="formulario__label" for="costoneto">Costo Neto</label>
                    <input disabled class="formulario__input" type="number" step="any" min="0" name="costoneto" id="costoneto" placeholder="EJ. 5" value="<?php echo s($producto->costoneto) ?>">
                </div>
            </div>

            <div>
                <p class="formulario__descripcion">Precios del producto</p>

                <div class="formulario__campo">
                    <label class="formulario__label" for="publico1">Publico1</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="publico1" id="publico1" placeholder="EJ. 5" value="<?php echo s($producto->precios->publico1) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="herrero2">Herrero2</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="herrero2" id="herrero2" placeholder="EJ. 5" value="<?php echo s($producto->precios->herrero2) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="herrero3">Herrero3</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="herrero3" id="herrero3" placeholder="EJ. 5" value="<?php echo s($producto->precios->herrero3) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="herrero4">Herrero4</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="herrero4" id="herrero4" placeholder="EJ. 5" value="<?php echo s($producto->precios->herrero4) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="mayoreo1">Mayoreo1</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="mayoreo1" id="mayoreo1" placeholder="EJ. 5" value="<?php echo s($producto->precios->mayoreo1) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="mayoreo2">Mayoreo2</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="mayoreo2" id="mayoreo2" placeholder="EJ. 5" value="<?php echo s($producto->precios->mayoreo2) ?>">
                </div>

            </div>




        </fieldset>



        <fieldset class="formulario__fieldset fieldset-grid">
            <legend class="formulario__legend">Datos de la Categoria del Producto</legend>

            <div>
                <div class="formulario__campo">
                    <label class="formulario__label" for="nombre">Nombre de la Categoría</label>
                    <input disabled class="formulario__input" type="text" name="nombre" id="nombre" value="<?php echo s($producto->categoria->nombre) ?>">
                </div>

                <p class="formulario__descripcion">Impuestos de la Categoría del Producto</p>

                <div class="formulario__campo">
                    <label class="formulario__label" for="flete">Flete</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="flete" id="flete" placeholder="EJ. 5" value="<?php echo s($producto->categoria->impuestos->flete) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="seguro">Seguro</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="seguro" id="seguro" placeholder="EJ. 5" value="<?php echo s($producto->categoria->impuestos->seguro) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="descarga">Descarga</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="descarga" id="descarga" placeholder="EJ. 5" value="<?php echo s($producto->categoria->impuestos->descarga) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="iva">Iva</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="iva" id="iva" placeholder="EJ. 5" value="<?php echo s($producto->categoria->impuestos->iva) ?>">
                </div>


            </div>

            <div>
                <p class="formulario__descripcion">Ganancias de la Categoria del Producto (%).</p>


                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciapublico1">Ganancia Publico1</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciapublico1" id="gananciapublico1" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciapublico1) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciaherrero2">Ganancia Herrero2</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciaherrero2" id="gananciaherrero2" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciaherrero2) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciaherrero3">Ganancia Herrero3</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciaherrero3" id="gananciaherrero3" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciaherrero3) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciaherrero4">Ganancia Herrero4</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciaherrero4" id="gananciaherrero4" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciaherrero4) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciamayoreo1">Ganancia Mayoreo1</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciamayoreo1" id="gananciamayoreo1" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciamayoreo1) ?>">
                </div>

                <div class="formulario__campo">
                    <label class="formulario__label" for="gananciamayoreo2">Ganancia Mayoreo2</label>
                    <input disabled class="formulario__input" type="number" min="0" step="any" name="gananciamayoreo2" id="gananciamayoreo2" placeholder="EJ. 5" value="<?php echo s($producto->categoria->ganancias->gananciamayoreo2) ?>">
                </div>

                <a class="formulario__enlace" href="/admin/categoria">Gestionar Categorias de Producto</a>

            </div>
        </fieldset>


        <?php if (!is_null($producto->tiposaceros_id)) { ?>
            <fieldset class="formulario__fieldset fieldset-grid">
                <legend class="formulario__legend">Datos Tipos de Acero</legend>
                <div>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="nombre">Nombre del Tipo de Acero</label>
                        <input disabled class="formulario__input" type="text" name="nombre" id="nombre" value="<?php echo s($producto->aceros->nombre) ?>">
                    </div>

                    <div class="formulario__campo">
                        <label class="formulario__label" for="categoria">Categoria del Tipo de Acero</label>
                        <input disabled class="formulario__input" type="text" name="categoria" id="categoria" value="<?php echo s($producto->aceros->categoriaAcero->categoria) ?>">
                    </div>

                    <div class="formulario__campo">
                        <label class="formulario__label" for="descripcion">Descripción del Tipo de Acero</label>
                        <input disabled class="formulario__input" type="text" name="descripcion" id="descripcion" value="<?php echo s($producto->aceros->descripcionAcero->descripcion) ?>">
                    </div>

                </div>


                <div>
                    <p class="formulario__descripcion">Precios por Tipo de Acero</p>

                    <div class="formulario__campo">
                        <label class="formulario__label" for="prolamsa">Prolamsa</label>
                        <input disabled class="formulario__input" type="number" min="0" step="any" name="prolamsa" id="prolamsa" placeholder="EJ. 5" value="<?php echo s($producto->aceros->prolamsa) ?>">
                    </div>

                    <p class="formulario__descripcion">Para los productos que se les asignó un tipo de acero, este valor coincide con su costo base.</p>
                    <div class="formulario__campo">
                        <label class="formulario__label" for="slp">SLP</label>
                        <input disabled class="formulario__input" type="number" min="0" step="any" name="slp" id="slp" placeholder="EJ. 5" value="<?php echo s($producto->aceros->slp) ?>">
                    </div>

                    <div class="formulario__campo">
                        <label class="formulario__label" for="arcoMetal">ArcoMetal</label>
                        <input disabled class="formulario__input" type="number" min="0" step="any" name="arcoMetal" id="arcoMetal" placeholder="EJ. 5" value="<?php echo s($producto->aceros->arcoMetal) ?>">
                    </div>

                </div>

                <a class="formulario__enlace" href="/admin/acero?categoria=<?php echo $producto->aceros->categoriaacero_id;?>">Gestionar Tipos de Acero</a>

            </fieldset>


        <?php } ?>


    </form>


    <div class="flex-centro contenedor">
        <a class="btn btn-editar" href="/admin/producto-comercial/actualizar?id=<?php echo $producto->id ?>">Editar</a>
        <form>
            <input class="eliminar-productoComercial" type="hidden" name="id" value="<?php echo $producto->id ?>">
            <input class="btn btn-eliminar" type="submit" value="Eliminar">
        </form>
    </div>
</div>
<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>