<main class="conteiner__form-altaDeCategorias">
    <div class="bg-light rounded-2 pt-3 pb-4">
        <h1 class="text-center mb-3">Editar Categoria</h1>
        <?php $validation = \Config\Services::validation() ?>
        <form action="<?php echo base_url('enviar-formCategoriaActualizar'); ?>" method="POST">
            <?= csrf_field() ?> 
            <div class="row mt-3">
                <!-- Campo oculto para el id -->
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="hidden" name="id" readonly value="<?= $categoria['id']; ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>

                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="categoria"><b>Descripción</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="categoria" name="categoria" placeholder="Ingrese la descripción de la categoria..." value="<?= session()->getFlashdata('limpiarCategoriaValor') ? '' : $categoria['descripcion'] ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('categoria')) {?> 
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('categoria'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>

            <div class="mt-3 d-flex justify-content-center"> 
                <input type="submit" value="Editar" class="text-white w-25 rounded-2 conteiner__form-div-input-agregarCancelar">
                <a href= "<?php echo base_url('limpiarCategoriaAct/' . $categoria['id']); ?>" class="w-25 ms-3 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>