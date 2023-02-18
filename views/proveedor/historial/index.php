<?php include_once __DIR__ . '/../../templates/header-dashboard.php'; ?>
<div class="contenedor">
    <?php include_once __DIR__ . '/../../templates/alertas.php' ?>

    <form method="POST" class="filtro filtro--no-margin">

        <input class="formulario__input" type="date" name="fecha" >

        <div class="filtro__buscador">
            <input type="text" class="filtro__input" name="cliente" placeholder="Ingrese Nombre">
        </div>

        <input type="submit" class="btn-submit" value="Buscar">


    </form>


    <?php if (empty($pedidos)) { ?>
        <p class="text-center">No Hay Ningún Pedido Asociado</p>
    <?php } else { ?>

        <table class="table contenedor-sombra mt-4">
            <thead class="table__head">

                <tr>
                    <th class="table__th ">Folio</th>
                    <th class="table__th ">Fecha</th>
                    <th class="table__th ">Cliente</th>
                    <th class="table__th ">Total</th>
                    <th class="table__th ">Abono</th>
                    <th class="table__th">Pagado</th>

                </tr>
            </thead>
            <tbody class="table__body">

                <?php foreach ($pedidos as $pedido) { ?>
                    <tr class="table__tr">
                        <td class="table__td "> <?php echo $pedido->folio ?></td>
                        <td class="table__td "> <?php echo $pedido->fecha ?></td>
                        <td class="table__td "> <?php echo $pedido->cliente->nombre ?></td>
                        <td class="table__td"> <?php echo $pedido->total ?></td>
                        <td class="table__td <?php echo $pedido->pagado == 0 ? 'table__td--resaltar' : '' ?> <?php echo $pedido->pagado == 0 ? 'table--abono' : '' ?>" data-abono=" <?php echo $pedido->id ?>"> <?php echo $pedido->abono ?></td>
                        <td class="table__td <?php echo $pedido->pagado == 1 ? 'table__td--si' : 'table__td--no' ?>"> <?php echo $pedido->pagado == 1 ? 'Si' : 'No' ?></td>

                    </tr>

                <?php } ?>
            </tbody>
        </table>

    <?php } ?>


</div>
<?php include_once __DIR__ . '/../../templates/footer-dashboard.php' ?>