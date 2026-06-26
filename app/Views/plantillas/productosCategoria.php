<?php 
    $acumulador = 0;
    $acumuladorCategoria = 0;
    $boleano = true;

    foreach ($productosTotal as $producto) {
        if ($categoria['id_categoria'] == $producto['id_categoria'] && $producto['eliminado'] == 'NO') {
            $boleano = false;
            break;
        }
    }
?>

<main class="contenedor__productos">
    <?php if($boleano == false && count($productos) > 0): ?>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-5">
                <div class="row">
                    <div class="col-12 mb-4">
                        <h5 class="text-dark"><b>Productos</b></h5>
                        <p class="opacity-75 mt-1 mb-1">
                            <?php foreach($productosTotal as $producto): ?>
                                <?php if($producto['id_categoria'] == $categoria['id_categoria'] && $producto['eliminado'] == 'NO' && $producto['activo_marca'] == 1): ?>
                                    <?php ++$acumulador; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php $menor = (count($productos) < $acumulador) ? count($productos) : $acumulador; ?>
                            <?php echo $menor; ?> resultados
                        </p>
                    </div>
                    <div class="col-12 mb-4">
                        <h5 class="text-dark"><b>Marcas</b></h5>
                        <?php foreach($marcas as $marca): ?>
                            <?php if($marca['activo'] == 1): ?>
                                <a href="<?php echo base_url('marca/' . $marca['id_marca']); ?>" class="text-decoration-none text-dark opacity-75 mt-1 mb-1"><?php echo $marca['descripcion']; ?> 
                                    <?php foreach($productosTotal as $producto): ?>
                                        <?php if($producto['eliminado'] == 'NO' && $producto['id_marca'] == $marca['id_marca'] && $producto['activo_marca'] == 1 && $producto['activo_categoria'] == 1): ?>
                                            <?php ++$acumuladorCategoria; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    (<?php echo $acumuladorCategoria; ?>)
                                </a><br>
                            <?php endif; ?>
                            <?php $acumuladorCategoria = 0; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12 mb-4">
                        <h5 class="text-dark" ><b>Precio</b></h5>
                        <form action="<?php echo base_url('enviar-formPrecioCategoria/' . $categoria['id_categoria']); ?>" method="GET">
                            <input type="number" name="precioMin" placeholder="Mínimo" title="Ingrese el precio mínimo para el filtro" min="0" required class="w-75 mb-1 ps-2 pe-2 pt-1 pb-1 border-0 rounded-1 shadow">
                            <input type="number" name="precioMax" placeholder="Máximo" title="Ingrese el precio máximo para el filtro" min="0" required class="w-75 mb-1 ps-2 pe-2 pt-1 pb-1 border-0 rounded-1 shadow">
                            <input type="submit" value="Buscar" class="text-white text-decoration-none w-75 mt-2 rounded-2 container__div-form-input-productos">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 col-7 card bg-white contenedor__productos-div-div">
                <div class="mt-1 border-bottom d-flex justify-content-end">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <b>Ordenar por</b>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo base_url('productosMayorPrecioCategoria/' . $categoria['id_categoria']); ?>"><b>Mayor Precio</b></a></li>
                            <li><a class="dropdown-item" href="<?php echo base_url('productosMenorPrecioCategoria/' . $categoria['id_categoria']); ?>"><b>Menor Precio</b></a></li>
                        </ul>
                    </div>
                </div>
                <?php foreach($productos as $producto): ?>
                    <?php if($categoria['id_categoria'] == $producto['id_categoria'] && $producto['eliminado'] == 'NO' && $producto['activo_marca'] == 1): ?>
                        <div class="row g-0 pt-2 pb-2 border-bottom">
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <img src="<?= base_url('assets/uploads/' . $producto['imagen']); ?>" class="img-fluid rounded-start" width="300px" alt="Producto">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-dark"><b><?php echo $producto['nombre']; ?></b></h5>
                                    <p class="card-text text-dark opacity-75"><?php echo $producto['descripcion']; ?></p>
                                    <?php if($producto['precio'] > $producto['precio_vta']): ?>
                                        <span class="text-decoration-line-through text-decoration-none text-dark text-opacity-75">$<?php echo number_format($producto['precio'], 2); ?></span>
                                        <h4 class="text-dark">
                                            <b>$<?php echo number_format($producto['precio_vta'], 2); ?></b>
                                            <span class="fs-5 text-white ps-1 pe-1 border border-0 rounded-1 contenedor__div-span-oferta">
                                                <b>%<?= round((($producto['precio'] - $producto['precio_vta']) / $producto['precio']) * 100); ?> OFF</b>
                                            </span>
                                        </h4>
                                    <?php else: ?>
                                        <h4 class="text-dark"><b>$<?php echo number_format($producto['precio_vta'], 2); ?></b></h4>
                                    <?php endif; ?>
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
    <?php else: ?>
        <div class="bg-white pt-5 pb-5">
            <div class="text-center">
                <img src="<?= base_url('assets/img/Producto no disponible.png'); ?>" alt="Producto no disponible" width="140px">
            </div>
            <h4 class="text-center ps-4 pe-4"><b>No hay productos disponibles en estos momentos</b></h4>
            <p class="text-center opacity-75 ps-4 pe-4">Más tarde se agregarán nuevos productos. ¡Vuelve pronto!</p>
        </div>
    <?php endif; ?>
</main>