<?php
    $boleano = true;

    foreach ($perfiles as $perfil) {
        if ($perfil['baja'] == 'NO') {
            $boleano = false;
            break;
        }
    }
?>

<main class="conteiner__listaDePerfiles">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Perfiles</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaPerfilesParaActivar'); ?>" class="btn btn-danger text-white rounded-2"><b>Desactivos</b></a>
        </div>
        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>
        <div class="listaDePerfiles-scroll">
            <div class="row w-100 ms-0 border-top">
                <div class="col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-5 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Perfiles</b></p>
                </div>
                <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Editar</b></p>
                </div>
                <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Eliminar</b></p>
                </div>
            </div>
            <?php if($boleano == true): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Perfil no agregado.png'); ?>" alt="Perfil no agregado" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay perfiles registrados</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($perfiles as $perfil): ?>
                    <?php if($perfil['baja'] == 'NO'): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $perfil['id_perfil']; ?></p>
                            </div>
                            <div class="col-5 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $perfil['descripcion']; ?></p>
                            </div>
                            <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center"> 
                                <a href= "<?php echo base_url('actualizarPerfiles/' . $perfil['id_perfil']); ?>" class="btn btn-primary text-white rounded-2"><b>Editar</b></a>
                            </div>
                            <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center"> 
                                <a href= "<?php echo base_url('eliminarPerfiles/' . $perfil['id_perfil']); ?>" class="btn btn-danger text-white rounded-2"><b>Eliminar</b></a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>