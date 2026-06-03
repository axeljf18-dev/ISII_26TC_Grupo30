<?php 
    $session = session();
    $valorFechaInicioQuery20 = $session->getFlashdata('fechaInicioQueryValor20');
    $valorFechaFinQuery20 = $session->getFlashdata('fechaFinQueryValor20');
    $valorFechasIncorrectas = $session->getFlashdata('msgFechasIncorrectas');
?>

<main class="conteiner__misCompras">
    <?php if(empty($ventas) && $valorFechasIncorrectas == false): ?>
        <div class="row bg-light rounded-2 w-100 pt-5 pb-5">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 text-center"><b>No has realizado ninguna compra aún</b></p>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 d-flex justify-content-center align-items-center">
                <a href="<?= base_url('productos') ?>" class="text-white text-decoration-none rounded-2 me-2 conteiner__div-boton-carrito"><b>Ir a Comprar</b></a>
            </div>
        </div>
    <?php elseif(empty($ventas) && $valorFechasIncorrectas == true): ?>
        <div class="row bg-light rounded-2 w-100 pt-5 pb-5">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 text-center"><b>No se encontraron registros para las fechas especificadas</b></p>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 d-flex justify-content-center align-items-center">
                <a href="<?php echo base_url('misCompras'); ?>" class="text-white text-decoration-none rounded-2 me-2 conteiner__div-boton-carrito"><b>Ir a Mis Compras</b></a>
            </div>
        </div>
    <?php else: ?>
        <div class="mb-1 d-flex justify-content-end">
            <form class="w-100" action="<?php echo base_url('enviar-formFechaQuery20'); ?>" method="GET">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                        <p class="mb-0 w-75 mx-auto"><b>Buscar desde: </b></p>
                        <input type="date" name="fechaInicioQuery20" value="<?= $valorFechaInicioQuery20; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                        <p class="mb-0 w-75 mx-auto"><b>Buscar hasta: </b></p>
                        <input type="date" name="fechaFinQuery20" value="<?= $valorFechaFinQuery20; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <button class="text-white w-25 mt-2 mb-3 p-2 border btn"><b>Buscar</b></button>
                </div>
            </form>
        </div>
        <div class="bg-light pb-3 pt-2 ps-2 pe-2">
            <h1 class="text-center bg-light mb-3 pt-2">Historial de Compras</h1>
            <div class="contenedor__tablaMisCompras">
                <table class="table table-striped shadow">
                    <thead>
                        <tr>
                            <th class="text-center">Titular</th>
                            <th class="text-center">Fecha (Tiempo)</th>
                            <th class="text-center">Total ($)</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $numero = 0; ?>
                        <?php foreach($ventas as $venta): ?>
                            <?php foreach($usuarios as $usuario): ?>
                                <?php if($usuario['id_usuario'] == $venta['id_usuario']): ?>
                                <tr>
                                    <td class="text-center"><?= $usuario['apellido'] ?>, <?= $usuario['nombre'] ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $fechaObj = new DateTime($venta['fecha']);
                                            $soloFecha = $fechaObj->format('Y-m-d');
                                            $soloHora = $fechaObj->format('H:i:s');
                                        ?>
                                        <?= $soloFecha ?> (<?= $soloHora ?>)
                                    </td>
                                    <td class="text-center">$<?= number_format($venta['total_venta'], 2) ?></td>
                                    <td class="text-center">
                                        <div class="text-center">
                                            <a href="<?= base_url('vistaDetalleCompra/' . $venta['id_venta_cabecera']) ?>" class="text-decoration-none">
                                                <b class="text-white p-1 bg-opacity-75 rounded-2">Detalles</b>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <?php if(isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links('default', 'my_template') ?>
        </div>
    <?php endif; ?>
</main>