<?php
    $session = session();
    $valorConsultaNombre = $session->getFlashdata('consultaNombreValor');
    $valorConsultaApellido = $session->getFlashdata('consultaApellidoValor');
    $valorConsultaDni = $session->getFlashdata('consultaDniValor');
    $valorConsultaTelefono = $session->getFlashdata('consultaTelefonoValor');
    $valorConsultaEmail = $session->getFlashdata('consultaEmailValor');
    $valorConsultaHecha = $session->getFlashdata('consultaHechaValor');
?>

<main class="conteiner__form-consultas">
    <div class="bg-light rounded-2 pt-3 pb-4 ms-5 me-5">
        <h1 class="text-center mb-3">Déjanos tu Consulta</h1>

        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>

        <?php $validation = \Config\Services::validation() ?>
        <form class="row" action="<?php echo base_url('enviar-formConsulta'); ?>" method="POST">
            <?= csrf_field() ?> 
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="nombre"><b>Nombre Completo</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="text" name="nombre" id="nombre" placeholder="Ingrese su nombre..." value="<?= esc($valorConsultaNombre); ?>" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('nombre')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('nombre'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="apellido"><b>Apellido Completo</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="text" name="apellido" id="apellido" placeholder="Ingrese su apellido..." value="<?= esc($valorConsultaApellido); ?>" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('apellido')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('apellido'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="dni"><b>DNI</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="number" name="dni" id="dni" placeholder="Ingrese su dni..." value="<?= esc($valorConsultaDni); ?>" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('dni')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('dni'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="telefono"><b>Teléfono</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="number" name="telefono" id="telefono" placeholder="Ingrese su numero telefónico..." value="<?= esc($valorConsultaTelefono); ?>" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('telefono')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('telefono'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="email"><b>Correo Electrónico</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="email" name="email" id="email" placeholder="Ingrese su correo..." value="<?= esc($valorConsultaEmail); ?>" title="Debe ser un correo válido de Gmail (por ejemplo, usuario@gmail.com)" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
                <?php if($validation->getError('email')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('email'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                <div class="d-flex justify-content-center">
                    <label for="consulta"><b>Consulta</b></label>
                </div>
                <div class="d-flex justify-content-center">
                    <textarea name="consulta" id="consulta" placeholder="Ingrese la consulta que desea realizar..." rows="5" class="w-75 ps-2 pe-2 pt-1 pb-1 border shadow"><?= esc($valorConsultaHecha); ?></textarea>
                </div>
                <?php if($validation->getError('consulta')) {?>
                    <div class="text-center mt-2"> 
                        <p class="fs-6 text-danger"><b><?= $error = $validation->getError('consulta'); ?> </b></p>
                    </div> 
                <?php }?>
            </div>
            <div class="w-100 ps-5 pe-5 mt-3 d-flex justify-content-center">
                <input type="submit" value="Enviar" class="text-white rounded-2 conteiner__form-div-input-enviarConsulta" style="width: 200.8px;">
                <a href= "<?php echo base_url('limpiarConsulta'); ?>" class="ms-3 btn btn-danger text-white rounded-2" style="width: 200.8px;"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>