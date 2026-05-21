<?php 
    $session = session();
    $boleano = empty($ventas);
    $valorFechaInicioQuery = $session->getFlashdata('fechaInicioQueryValor');
    $valorFechaFinQuery = $session->getFlashdata('fechaFinQueryValor');
    $valorFechasIncorrectasDeVentas = $session->getFlashdata('msgFechasIncorrectasDeVentas');
?>

<main class="conteiner__listaDeVentas">
    <div class="mb-1 d-flex justify-content-end">
        <form class="w-100" action="<?php echo base_url('enviar-formFechaQuery'); ?>" method="POST">
            <div class="mb-2">
                <p class="mb-0"><b>Buscar desde: </b></p>
                <input type="search" name="fechaInicioQuery" placeholder="Escribe la fecha de inicio de la venta que quieres buscar..." value="<?= $valorFechaInicioQuery; ?>" title="(por ejemplo: 2025-06-01)" class="w-100 p-2 border shadow">
            </div>
            <div class="mb-2">
                <p class="mb-0"><b>Buscar hasta: </b></p>
                <input type="search" name="fechaFinQuery" placeholder="Escribe la fecha de fin de la venta que quieres buscar..." value="<?= $valorFechaFinQuery; ?>" title="(por ejemplo: 2025-06-06)" class="w-100 p-2 border shadow">
            </div>
            <div class="w-100 d-flex justify-content-center align-items-center">
                <button class="w-25 mt-2 mb-3 p-2 border btn btn-primary"><b>Buscar</b></button>
            </div>
        </form>
    </div>
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Ventas</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaVentasDesactivadas'); ?>" class="btn btn-danger text-white rounded-2"><b>Desactivos</b></a>
        </div>
        <div class="listaDeVentas-scroll">
            <div class="row w-100 ms-0 border-top">
                <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Titular</b></p>
                </div>
                <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Fecha</b></p>
                </div>
                <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Total ($)</b></p>
                </div>
                <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Acciones</b></p>
                </div>
            </div>
            <?php if($boleano == true && $valorFechasIncorrectasDeVentas == false): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registrada" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, aún no hay ventas realizadas</b></h4>
                </div>
            <?php elseif($boleano == true && $valorFechasIncorrectasDeVentas == true): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registrada" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>No se encontraron registros para las fechas especificadas</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($ventas as $venta): ?>
                    <div class="row w-100 ms-0 border-top">
                        <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <p class="mb-0"><?= $venta['usuario_nombre']; ?></p>
                        </div>
                        <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <p class="mb-0"><?= $venta['fecha']; ?></p>
                        </div>
                        <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <p class="mb-0">$<?= number_format($venta['total_venta'], 2); ?></p>
                        </div>
                        <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <a href="<?= base_url('mostrarDetalleCompraCliente/' . $venta['id_venta_cabecera']) ?>" class="btn btn-primary text-white">
                                <b>Detalles</b>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if(isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links('default', 'my_template') ?>
        </div>
    <?php endif; ?>
</main>