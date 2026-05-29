<?php
    $session = session();
    $valorEmail2 = $session->getFlashdata('emailValor2');
    $valorContraseña2 = $session->getFlashdata('passwordValor2');
?>

<main class="conteiner__form-inicioSesion">
    <div class="bg-light rounded-2 pt-3 pb-4">
        <h1 class="text-center mb-3">¿Tenés una Cuenta?</h1>
        <?php if(session()->getFlashdata('msgUser')): ?>
            <div class="text-center mt-2"> 
                <p class="fs-6 text-danger"><b><?= session()->getFlashdata('msgUser'); ?></b></p>
            </div> 
        <?php endif; ?>

        <?php $validation = \Config\Services::validation() ?>
        <form action="<?php echo base_url('/enviar-login'); ?>" method="POST">
            <?= csrf_field() ?> 
            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="email"><b>Correo Electrónico(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="email" id="email" name="email" placeholder="Ingrese su correo..." value="<?= esc($valorEmail2); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>
            <?php if(session()->getFlashdata('msgEmail')): ?>
                <div class="text-center mt-2">
                    <p class="fs-6 text-danger"><b><?= session()->getFlashdata('msgEmail'); ?></b></p>
                </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="contraseña"><b>Contraseña(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="password" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña..." value="<?= esc($valorContraseña2); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>
            <?php if(session()->getFlashdata('msgPassword')): ?>
                <div class="text-center mt-2">
                    <p class="fs-6 text-danger m-0"><b><?= session()->getFlashdata('msgPassword'); ?></b></p>
                </div>
                <?php endif; ?>
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-center">
                    <a href="<?php echo base_url('registrarse'); ?>" class="text-decoration-none text-dark opacity-75">¿Aún no tenés tu cuenta?</a> 
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-center"> 
                <input type="submit" value="Ingresar" class="text-white w-25 rounded-2 conteiner__form-div-input-ingresarCancelar">
                <a href= "<?php echo base_url('limpiarSesion'); ?>" class="w-25 ms-3 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>