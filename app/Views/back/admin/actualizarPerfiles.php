<main class="conteiner__form-altaDePerfiles">
    <div class="bg-light rounded-2 pt-3 pb-4">
        <h1 class="text-center mb-3">Editar Perfil</h1>
        <?php $validation = \Config\Services::validation() ?>
        <form action="<?php echo base_url('enviar-formPerfilActualizar'); ?>" method="POST">
            <?= csrf_field() ?> 
            <div class="row mt-3">
                <!-- Campo oculto para el id -->
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="hidden" name="id" readonly value="<?= $perfil['id_perfil']; ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>

                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="perfil"><b>Descripción</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="perfil" name="perfil" placeholder="Ingrese la descripción de un perfil..." value="<?= session()->getFlashdata('limpiarPerfilValor') ? '' : $perfil['descripcion'] ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('perfil')) {?> 
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('perfil'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>

            <div class="mt-3 d-flex justify-content-center"> 
                <input type="submit" value="Editar" class="text-white w-25 rounded-2 conteiner__form-div-input-agregarCancelar">
                <a href= "<?php echo base_url('limpiarPerfilAct/' . $perfil['id_perfil']); ?>" class="w-25 ms-3 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>