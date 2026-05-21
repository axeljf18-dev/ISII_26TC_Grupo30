<?php
    $session = session();
    $boleano = false;

    foreach ($usuarios as $usuario) {
        if ($usuario['baja'] == 'SI') {
            $boleano = true;
            break;
        }
    }

    $valorUsuarioDesactivadoQuery = $session->getFlashdata('usuarioDesactivadoQueryValor');
?>

<main class="conteiner__listaDeUsuarios">
    <div class="mb-1 d-flex justify-content-end">
        <form class="w-100 d-flex justify-content-end" action="<?php echo base_url('enviar-formUsuarioDesactivadoQuery'); ?>" method="POST">
            <div class="w-100 d-flex align-items-center">
                <input type="search" name="usuarioDesactivadoQuery" placeholder="Escribe el nombre del usuario que quieres buscar..." value="<?= $valorUsuarioDesactivadoQuery; ?>" class="w-100 p-2 border rounded-start-2">
            </div>
            <div class="d-flex align-items-center">
                <button class="bg-white border p-2 rounded-end-2">
                    <img src="<?= base_url('assets/img/lupa.png'); ?>" alt="Lupa" height="20px" class="opacity-75">
                </button>
            </div>
        </form>
    </div>
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Usuarios no Habilitados</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaUsuarios'); ?>" class="btn btn-secondary text-white rounded-2"><b>Volver</b></a>
        </div>
        <div class="listaDeUsuarios-scroll">
            <div class="row w-100 ms-0 border-top">
                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>ID</b></p>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Nombre y Apellido</b></p>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-6 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Email</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Perfil</b></p>
                </div>
            </div>
            <?php if($boleano == false): ?>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/Perfil no agregado.png'); ?>" alt="Usuario no agregado" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>Ups, parece que no hay usuarios dado de baja</b></h4>
                </div>
            <?php else: ?>
                <?php foreach($usuarios as $usuario): ?>
                    <?php if($usuario['baja'] == 'SI'): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $usuario['id_usuario']; ?></p>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $usuario['nombre']; ?>, <?php echo $usuario['apellido']; ?></p>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-6 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $usuario['email']; ?></p>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?php echo $usuario['perfil_descripcion']; ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if(isset($pager)): ?>
        <div class="d-flex justify-content-end mt-3">
            <?= $pager->links('default', 'my_template') ?>
        </div>
    <?php endif; ?>
</main>