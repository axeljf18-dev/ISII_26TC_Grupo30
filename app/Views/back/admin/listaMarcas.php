<?php
    $boleano = true;

    foreach ($marcas as $marca) {
        if ($marca['activo'] == 1) {
            $boleano = false;
            break;
        }
    }
?>

<main class="conteiner__listaDeMarcas">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Marcas</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaMarcasDesactivados'); ?>" class="btn btn-danger text-white rounded-2"><b>Desactivos</b></a>
        </div>
        <div>
            <div class="row w-100 ms-0 border-top">
                <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-8 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Marcas</b></p>
                </div>
            </div>
            <?php if($boleano == true): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Marca no agregada.png'); ?>" alt="Marca no agregada" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay marcas registradas</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($marcas as $marca): ?>
                    <?php if($marca['activo'] == 1): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $marca['id_marca']; ?></p>
                            </div>
                            <div class="col-8 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $marca['descripcion']; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>