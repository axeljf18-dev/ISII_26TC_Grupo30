<!-- confirmacion.php -->
<main class="confirmacion__main">
    <div class="confirmacion__card">
        <div class="confirmacion__header 
            <?php if ($accion === 'eliminar'): ?>
                bg-danger text-white
            <?php elseif ($accion === 'activar'): ?>
                bg-primary text-white
            <?php endif; ?>
                p-3 rounded-top text-center">
            Confirmar acción
        </div>
        <div class="confirmacion__body border">
            <p>¿Estás seguro de que deseas <?= $accion ?> el producto <b><?= $producto['nombre'] ?></b>?</p>
        </div>
        <div class="confirmacion__footer">
            <?php if ($accion === 'eliminar'): ?>
                <a href="<?= base_url('eliminarProductos/'.$producto['id_producto']); ?>" class="btn btn-danger"><b>Aceptar</b></a>
            <?php elseif ($accion === 'activar'): ?>
                <a href="<?= base_url('activarProductos/'.$producto['id_producto']); ?>" class="btn btn-primary"><b>Aceptar</b></a>
            <?php endif; ?>
                <a href="<?= base_url('mostrarListaProductosActualizarEliminar'); ?>" class="btn btn-secondary"><b>Cancelar</b></a>
        </div>
    </div>
</main>