<?php 
    $session = session();
    $boleano = true;

    foreach ($productos as $producto) {
        if ($producto['eliminado'] == 'NO') {
            $boleano = false;
            break;
        }
    }

    $valorProductoQuery = $session->getFlashdata('productoQueryValor');
?>

<main class="conteiner__listaDeProductos">
    <div class="mb-1 d-flex justify-content-end">
        <form class="w-100 d-flex justify-content-end" action="<?php echo base_url('enviar-formProductoQuery'); ?>" method="POST">
            <div class="w-100 d-flex align-items-center">
                <input type="search" name="productoQuery" placeholder="Escribe el nombre del producto que quieres buscar..." value="<?= $valorProductoQuery; ?>" class="w-100 p-2 border rounded-start-2">
            </div>
            <div class="d-flex align-items-center">
                <button class="bg-white border p-2 rounded-end-2">
                    <img src="<?= base_url('assets/img/lupa.png'); ?>" alt="Lupa" height="20px" class="opacity-75">
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Productos</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaProductosDesactivados'); ?>" class="btn btn-danger text-white rounded-2"><b>Desactivos</b></a>
        </div>
        <div class="listaDeProductos-scroll">
            <div class="row w-100 ms-0 border-top">
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Nombre</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Descripción</b></p>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Categoría</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Imagen</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 text-center border-end">
                    <p class="mb-0"><b>Precio Venta</b></p>
                </div>
            </div>
            <?php if($boleano == true): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Producto no disponible.png'); ?>" alt="Producto no agregado" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay productos registrados</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($productos as $producto): ?>
                    <?php if($producto['eliminado'] == 'NO'): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $producto['id_producto']; ?></p>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $producto['nombre']; ?></p>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $producto['descripcion']; ?></p>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $producto['categoria_descripcion']; ?></p>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <img src="<?= base_url('assets/uploads/' . $producto['imagen']); ?>" alt="Imagen del producto" width="100%" height="100px">
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0">$<?php echo number_format($producto['precio_vta'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
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