<?php
    $session = session();
    $valorNombre1 = $session->getFlashdata('nombreValor1');
    $valorApellido1 = $session->getFlashdata('apellidoValor1');
    $valorUsuario1 = $session->getFlashdata('usuarioValor1');
    $valorEmail1 = $session->getFlashdata('emailValor1');
    $valorContraseña1 = $session->getFlashdata('passwordValor1');

    $valorBarrio1 = $session->getFlashdata('barrioValor1');
    $valorCalle1 = $session->getFlashdata('calleValor1');
    $valorNumero1 = $session->getFlashdata('numeroValor1');
    $valorLocalidad1 = $session->getFlashdata('localidadValor1');
?>

<main class="conteiner__form-registrarse">
    <div class="bg-light rounded-2 pt-3 pb-4">
        <h1 class="text-center mb-3">Registrarse</h1>

        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>

        <?php $validation = \Config\Services::validation() ?>
        <form action="<?php echo base_url('/enviar-form'); ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="nombre"><b>Nombre(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre..." value="<?= esc($valorNombre1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="apellido"><b>Apellido(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido... "value="<?= esc($valorApellido1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="usuario"><b>Usuario(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario..." value="<?= esc($valorUsuario1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="email"><b>Correo Electrónico(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="email" id="email" name="email" placeholder="Ingrese su correo..." value="<?= esc($valorEmail1); ?>" title="Debe ser un correo válido de Gmail (por ejemplo, usuario123@gmail.com)" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="contraseña"><b>Contraseña(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="password" id="contraseña" name="contraseña" placeholder="Ingrese su contraseña..." value="<?= esc($valorContraseña1); ?>" title="Debe contener al menos una letra mayúscula, un número y un carácter especial (@$!%*?&)" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="barrio"><b>Barrio</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="barrio" name="barrio" placeholder="Ingrese su barrio..." value="<?= esc($valorBarrio1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="calle"><b>Calle</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="text" id="calle" name="calle" placeholder="Ingrese su calle..." value="<?= esc($valorCalle1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="numero"><b>Número</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <input type="number" id="numero" name="numero" placeholder="Ingrese el número..." value="<?= esc($valorNumero1); ?>" class="w-100 ps-2 pe-2 pt-1 pb-1 border shadow">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 mt-2 d-flex justify-content-center">
                    <label for="id_localidad"><b>Localidad(*)</b></label>      
                </div>
                <div class="col-12 mt-2 d-flex justify-content-center ps-5 pe-5">
                    <select id="localidad" name="localidad" class="opacity-75 w-100 p-2 border shadow" style="cursor: pointer;">
                        <option value="" disabled selected>Seleccione una localidad | provincia</option>
                        <?php foreach($localidades as $loc): ?>
                            <option value="<?= $loc['id_localidad'] ?>" 
                                <?= (isset($valorLocalidad1) && $valorLocalidad1 == $loc['id_localidad']) ? 'selected' : ''; ?>>
                                <?= esc($loc['localidad_nombre']) ?> | <?= esc($loc['provincia_nombre']) ?> (<?= esc($loc['codigo_postal']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if($session->getFlashdata('validationErrors')) {?> 
                <div class="mt-2 ms-4">
                    <p class="fs-6 text-danger ps-3"><b>• <?= implode('<br>• ', $session->getFlashdata('validationErrors')); ?></b></p>
                </div>
            <?php }?>

            <div class="mt-4 d-flex justify-content-center"> 
                <input type="submit" value="Registrarse" class="text-white w-25 me-3 rounded-2 conteiner__form-div-input-registrarseCancelar">
                <a href= "<?php echo base_url('limpiarUsuario'); ?>" class="w-25 ms-3 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
            </div>
        </form>
    </div>
</main>