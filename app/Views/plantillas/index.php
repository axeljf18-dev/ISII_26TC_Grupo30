<?php 
    $boleano = true;

    foreach ($productos as $producto) {
        if ($producto['eliminado'] == 'NO') {
            $boleano = false;
            break;
        }
    }
?>

<main>
    <div class="bg-light rounded-2 contenedor__div-index">
        <?php if($boleano == true): ?>
            <div class="bg-white pt-5 pb-5">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/Producto no disponible.png'); ?>" alt="Producto no disponible" width="140px">
                </div>
                <h4 class="text-center ps-4 pe-4"><b>No hay productos disponibles en estos momentos</b></h4>
                <p class="text-center opacity-75 ps-4 pe-4">Más tarde se agregarán nuevos productos. ¡Vuelve pronto!</p>
            </div>
        <?php else: ?>
            <div class="contenedor__h1-index">
                <h1><span class="ps-2 pe-2 text-white contenedor__h1-span">Productos en Ofertas</span></h1>
            </div>
            <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 g-4 p-2 d-flex justify-content-center">
                <?php foreach($productos as $producto): ?>
                    <?php if($producto['eliminado'] == 'NO' && $producto['precio'] > $producto['precio_vta']): ?>
                        <div class="col">
                            <div class="card h-100 shadow">
                                <img src="<?= base_url('assets/uploads/' . $producto['imagen']); ?>" class="card-img-top p-2" alt="Producto" height="160px">
                                <div class="card-body">
                                    <h5 class="card-title"><b><?php echo $producto['nombre'] ?></b></h5>
                                    <p class="card-text opacity-75 contenedor__div-p-descripcion"><?php echo $producto['descripcion'] ?></p>
                                    <div class="row d-flex align-items-center">
                                        <div class="col d-flex justify-content-end">
                                            <span class="text-decoration-line-through opacity-75">$<?php echo number_format($producto['precio'], 2); ?></span>
                                        </div>
                                        <div class="col d-flex justify-content-start h-25">
                                            <span class="text-white ps-1 pe-1 border border-0 rounded-1 contenedor__div-span-oferta">
                                                <b>%<?= round((($producto['precio'] - $producto['precio_vta']) / $producto['precio']) * 100); ?> OFF</b>
                                            </span>
                                        </div>
                                    </div>
                                    <h4 class="text-center"><b>$<?php echo number_format($producto['precio_vta'], 2); ?></b></h4>
                                    <?php if($producto['stock'] > 0): ?>
                                        <?php if($producto['stock'] >= $producto['stock_min']): ?>
                                            <p class="card-text text-dark opacity-75 mb-0">Disponibles: <?php echo $producto['stock']; ?></p>
                                            <p class="card-text text-dark mb-1"><b>¡Stock disponible!</b></p>
                                        <?php else: ?>
                                            <p class="card-text text-dark opacity-75 mb-0">Disponibles: <?php echo $producto['stock']; ?></p>
                                            <p class="card-text text-dark mb-1"><b>¡Últimos disponibles!</b></p>
                                        <?php endif; ?>
                                    <form action="<?= base_url('enviar-formCarritoAgregar/' . $producto['id_producto']); ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="submit" value="Añadir al carrito" class="text-white w-100 rounded-2 conteiner__div-boton-carrito" style="font-weight: bold;">
                                    </form>
                                    <?php else: ?>
                                            <p class="card-text text-dark opacity-75 mb-0">Disponibles: <?php echo $producto['stock']; ?></p>
                                            <p class="card-text text-dark mb-1"><b>Sin stock</b></p>
                                            <span class="text-white text-center p-2 bg-danger rounded-1 d-block" style="height:38px;"><b>No disponible</b></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    </div>

    <div class="container text-center mt-5">
        <div class="row row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-1 d-flex justify-content-center">
            <div class="col">
                <div>
                    <img src="<?= base_url('assets/img/envio.svg'); ?>" alt="Envio" width="80px" height="80px" class="contenedor__div-img-1-index">
                </div>
                <div>
                    <h5><b>Envío gratis</b></h5>
                    <p class="ps-5 pe-5 opacity-75">Solo por estar registrado en NetShop tenés envíos gratis de los productos que ofrecemos.</p>
                </div>
            </div>
            <div class="col">
                <div>
                    <img src="<?= base_url('assets/img/seguridad.svg'); ?>" alt="Seguridad" width="80px" height="80px" class="contenedor__div-img-1-index">
                </div>
                <div>
                    <h5><b>Seguridad, de principio a fin</b></h5>
                    <p class="ps-5 pe-5 opacity-75">En NetShop, no hay nada que no puedas hacer, porque estás siempre protegido.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</main>