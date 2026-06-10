<!-- confirmacion.php -->
<main class="confirmacion__main">
    <div class="confirmacion__card">
        <div class="confirmacion__header 
            <?php if ($accion === 'eliminar'): ?>
                bg-danger text-white
            <?php elseif ($accion === 'habilitar'): ?>
                bg-primary text-white
            <?php endif; ?>
                p-3 rounded-top text-center">
            Confirmar acción
        </div>
        <div class="confirmacion__body border">
            <p>¿Estás seguro de que deseas <?= $accion ?> el usuario <b><?= $usuario['nombre'] ?></b>?</p>
        </div>
        <div class="confirmacion__footer">
            <?php if ($accion === 'eliminar'): ?>
                <a href="<?= base_url('eliminarUsuarios/'.$usuario['id_usuario']); ?>" class="btn btn-danger"><b>Aceptar</b></a>
            <?php elseif ($accion === 'habilitar'): ?>
                <a href="<?= base_url('activarUsuarios/'.$usuario['id_usuario']); ?>" class="btn btn-primary"><b>Aceptar</b></a>
            <?php endif; ?>
                <a href="<?= base_url('mostrarListaUsuariosActualizarEliminar'); ?>" class="btn btn-secondary"><b>Cancelar</b></a>
        </div>
    </div>
</main>