<?php
    $boleano = false;

    foreach ($marcas as $marca) {
        if ($marca['activo'] == 2) {
            $boleano = true;
            break;
        }
    }
?>

<main class="conteiner__listaDeMarcas">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Marcas Desactivadas</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaMarcasActualizarEliminar'); ?>" class="btn btn-secondary text-white rounded-2"><b>Volver</b></a>
        </div>
        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>
        <div>
            <div class="row w-100 ms-0 border-top">
                <div class="col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-7 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Marcas</b></p>
                </div>
                <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Activar</b></p>
                </div>
            </div>
            <?php if($boleano == false): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Marca no agregada.png'); ?>" alt="Marca no agregada" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay marcas desactivadas</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($marcas as $marca): ?>
                    <?php if($marca['activo'] == 2): ?>
                    <div class="row w-100 ms-0 border-top">
                        <div class="col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <p class="mb-0"><?php echo $marca['id_marca']; ?></p>
                        </div>
                        <div class="col-7 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                            <p class="mb-0"><?php echo $marca['descripcion']; ?></p>
                        </div>
                        <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center"> 
                            <a href= "<?php echo base_url('activarMarcas/' . $marca['id_marca']); ?>" class="btn btn-primary text-white rounded-2"><b>Activar</b></a>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>