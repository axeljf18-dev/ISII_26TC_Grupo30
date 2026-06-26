<?php
    $boleano = false;

    foreach ($perfiles as $perfil) {
        if ($perfil['baja'] == 'SI') {
            $boleano = true;
            break;
        }
    }
?>

<main class="conteiner__listaDePerfiles">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Perfiles Desactivados</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaPerfiles'); ?>" class="btn btn-secondary text-white rounded-2"><b>Volver</b></a>
        </div>
        <div>
            <div class="row w-100 ms-0 border-top">
                <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-8 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Perfiles</b></p>
                </div>
            </div>
            <?php if($boleano == false): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Perfil no agregado.png'); ?>" alt="Perfil no agregado" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay perfiles desactivados</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($perfiles as $perfil): ?>
                    <?php if($perfil['baja'] == 'SI'): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $perfil['id_perfil']; ?></p>
                            </div>
                            <div class="col-8 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $perfil['descripcion']; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>