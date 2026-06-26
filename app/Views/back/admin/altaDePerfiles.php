<?php
    $session = session();
    $valorPerfilDescripcion = $session->getFlashdata('perfilDescripcionValor');
?>

<main class="conteiner__form-altaDePerfiles">
    <div class="bg-light rounded-2 pt-3 pb-4">
        <h1 class="text-center mb-3">Agregar Perfil</h1>

        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>

        <?php $validation = \Config\Services::validation() ?>
        <form action="<?php echo base_url('enviar-formPerfil'); ?>" method="POST">
            <?= csrf_field() ?> 
            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="perfil"><b>Descripción</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="perfil" name="perfil" placeholder="Ingrese la descripción de un perfil..." value="<?= esc($valorPerfilDescripcion); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('perfil')) {?> 
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('perfil'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>

            <div class="mt-3 d-flex justify-content-center"> 
                <input type="submit" value="Agregar" class="text-white w-25 me-5 rounded-2 conteiner__form-div-input-agregarCancelar">
                <a href= "<?php echo base_url('limpiarPerfil'); ?>" class="w-25 ms-3 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>