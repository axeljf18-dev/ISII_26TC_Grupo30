<?php 
    $session=session();
    $cart = \Config\Services::cart();
    $cart = $cart->contents();
?>

<main class="contenedor__div-carrito">
    <?php if (empty($cart)): ?>
        <div class="row bg-light rounded-2 pt-5 pb-5">
            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="text-center mt-2">
                    <p class="fs-5 text-white"><b class="p-1 bg-danger bg-opacity-75 rounded-2"><?= session()->getFlashdata('mensaje'); ?></b></p>
                </div>
            <?php endif; ?>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <p class="fs-5 text-center"><b>No hay productos en "Mi Carrito"</b></p>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2 d-flex justify-content-center align-items-center">
                <a href="<?= base_url('productos') ?>" class="text-white text-decoration-none rounded-2 me-2 conteiner__div-boton-carrito"><b>Ir a Comprar</b></a>
            </div>
        </div>
    <?php else: ?>
        <?php echo form_open('enviar-formActualizaCarrito'); ?>
        <div class="row bg-white">
            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="text-center mt-2">
                    <p class="fs-5 text-white"><b class="p-1 bg-danger bg-opacity-75 rounded-2"><?= session()->getFlashdata('mensaje'); ?></b></p>
                </div>
            <?php endif; ?>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7 col-6 mt-4 border-top">
                <?php $gran_total = 0; ?>
                <?php foreach ($cart as $item): ?>
                <!-- Campos ocultos para enviar datos al formulario -->
                <?= form_hidden('cart[' . $item['id'] . '][id]', $item['id']); ?>
                <?= form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']); ?>
                <?= form_hidden('cart[' . $item['id'] . '][name]', $item['name']); ?>
                <?= form_hidden('cart[' . $item['id'] . '][price]', (string)$item['price']); ?>
                <?= form_hidden('cart[' . $item['id'] . '][qty]', (string)$item['qty']); ?>
                <?= form_hidden('cart[' . $item['id'] . '][imagen]', (string)$item['imagen']); ?>
                <?php $gran_total += $item['price'] * $item['qty']; ?>

                <div class="row mb-4 pb-3 border-bottom border-end">
                    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 d-flex justify-content-center align-items-center">
                        <img src="<?= base_url('assets/uploads/' . $item['imagen']) ?>" width="100%" height="225px" alt="<?= $item['name']; ?>">
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-12 col-sm-12 col-12">
                        <div class="card-body pt-2">
                            <h5 class="card-title text-dark"><b><?= $item['name']; ?></b></h5>
                            <p class="card-text text-dark opacity-75"><?= $item['options']['descripcion'] ?? '' ?></p>
                            <h4 class="text-dark text-xl-start text-lg-start text-md-center text-sm-center text-center"><b>$<?= number_format($item['price'], 2) ?></b></h4>
                            <div class="text-xl-start text-lg-start text-md-center text-sm-center text-center">
                                <a href="<?= base_url('suma-carrito/' . $item['rowid']) ?>" class="text-decoration-none text-white rounded-1 pt-1 pb-1"><b>+</b></a>
                                <?= number_format($item['qty']) ?>
                                <a href="<?= base_url('resta-carrito/' . $item['rowid']) ?>" class="text-decoration-none text-white rounded-1 pt-1 pb-1"><b>&ndash;</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12 d-xl-flex d-lg-flex d-md-block d-sm-block d-block justify-content-center align-items-center">
                        <a href="<?= base_url('borrar-producto/' . $item['rowid']) ?>" class="text-white text-center text-decoration-none btn btn-danger rounded-2 me-2 mt-4 mb-4 d-block"><b>Eliminar</b></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php echo form_close(); ?>
            
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-6 mt-4 mb-4 pt-2 border-top border-bottom">
                <p class="opacity-75">Subtotal: $<?= number_format($gran_total, 2) ?></p>
                <h4 class="text-dark"><b>Total: $<?= number_format($gran_total, 2) ?></b></h4>

                <form action="<?= base_url('comprar-carrito') ?>" method="post" class="me-2">
                    <?= csrf_field() ?>

                    <label for="id_metodo_pago"><b>Método de Pago(*)</b></label>
                    <select name="id_metodo_pago" id="id_metodo_pago" class="form-select" style="cursor: pointer;">
                        <option value="" selected>Seleccione un método de pago</option>
                        <?php foreach($metodosPago as $metodo): ?>
                            <option value="<?= $metodo['id_metodo_pago'] ?>">
                                <?= esc($metodo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Botón de compra como submit -->
                    <button type="submit" class="text-white text-center text-decoration-none border-0 rounded-2 me-2 mt-4 mb-4 conteiner__div-boton-carrito w-100">
                        <b>Comprar</b>
                    </button>
                </form>

                <a href="<?= base_url('borrar-carrito') ?>" class="text-white text-center text-decoration-none btn btn-danger rounded-2 me-2 mt-4 mb-4 d-block">
                    <b>Borrar Todo</b>
                </a>
            </div>
        </div>
        
    <?php endif; ?>
</main>