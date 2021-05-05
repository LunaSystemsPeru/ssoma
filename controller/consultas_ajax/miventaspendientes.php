<?php
include '../../fixed/iniciaSession.php';
require '../../models/Venta.php';

$venta = new Venta();
$venta->setIdEmpresa($_SESSION['empresa']);
$venta->setIdCliente(filter_input(INPUT_POST, 'select_cliente'));

$adocumentos = $venta->verMisPendientes();

$nroitems = 0;
foreach ($adocumentos as $fila) {
    $nroitems++;
    ?>
    <tr>
        <td class="text-center"><?php echo  $nroitems ?></td>
        <td class="text-center"><?php echo "FT | " . $fila['serie'] . " - " . $fila['numero'] ?></td>
        <td class="text-center"><?php echo  $fila['fecha'] ?></td>
        <td class="text-right"><?php echo  number_format($fila['total'], 2) ?></td>
        <td class="text-right"><?php echo  number_format($fila['total'] - $fila['pagado'], 2) ?></td>
        <td class="text-right"><input class="form-control text-right" type="text" ></td>
        <td class="text-center">
            <button class="btn btn-danger btn-icon fa fa-trash"
                    onclick="eliminar('<?php echo "1" ?>')"></button>
        </td>
    </tr>

    <?php
}
?>
