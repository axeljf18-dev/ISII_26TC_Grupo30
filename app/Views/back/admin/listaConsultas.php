<?php
    $boleano = true;
    $numero = 0;

    foreach ($consultas as $consulta) {
        if ($consulta['baja'] == 'NO') {
            $boleano = false;
            break;
        }
    }
?>

<main class="conteiner__listaDeConsultas">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Lista de Consultas</h1>
        <div class="d-flex justify-content-end pb-2 pe-2">
            <a href= "<?php echo base_url('mostrarListaConsultasDesactivadas'); ?>" class="btn btn-danger text-white rounded-2"><b>Leídos</b></a>
        </div>
        <?php if(session()->getFlashdata('msgExitoso')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('msgExitoso'); ?></b></p>
            </div>
        <?php endif; ?>
        <?php if($boleano == true): ?>
            <div class="bg-white pt-5 pb-5 border-top">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/Marca no agregada.png'); ?>" alt="No hay consulta" width="140px">
                </div>
                <h4 class="text-center ps-4 pe-4"><b>Ups, aún no hay consultas registradas</b></h4>
                <p class="text-center opacity-75 ps-4 pe-4">Deberás esperar a que algún usuario envíe una</p>
            </div>
        <?php else: ?>
            <div class="listaDeConsultas-scroll">
                <div class="row w-100 ms-0 border-top">
                    <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Numero</b></p>
                    </div>
                    <div class="col-10 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Consultas</b></p>
                    </div>
                </div>
                <?php foreach($consultas as $consulta): ?>
                    <?php if($consulta['baja'] == 'NO'): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-2 border-end d-flex justify-content-center align-items-center">
                                <p><b><?php echo ++$numero; ?></b></p>
                            </div>
                            <div class="col-10 ms-0 ps-0 pe-0">
                                <div class="p-3 d-flex justify-content-between">
                                    <div class="w-100">
                                        <p class="mb-0"><b>Nombre y Apellido:</b> <?php echo $consulta['nombre']; ?>, <?php echo $consulta['apellido']; ?></p>
                                    </div>
                                    <div>
                                        <?php if($consulta['leido'] == 'NO'): ?>
                                            <a href= "<?php echo base_url('marcarConsulta/' . $consulta['id_consulta']); ?>" class="w-100 btn btn-primary text-white rounded-2"><b>Leer</b></a>
                                        <?php else: ?>
                                            <a href= "<?php echo base_url('eliminarConsulta/' . $consulta['id_consulta']); ?>" class="w-100 btn btn-danger text-white rounded-2"><b>Borrar</b></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="w-75 ms-0 d-flex justify-content-center">
                                        <div class="w-100 pb-3">
                                            <p class="mb-0"><b>DNI:</b> <?php echo $consulta['dni']; ?></p>
                                        </div>
                                        <div class="w-100 pb-3">
                                            <p class="mb-0"><b>Teléfono:</b> <?php echo $consulta['telefono']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="w-75 ms-0 d-flex justify-content-center">
                                        <div class="w-100 pb-3 pt-3">
                                            <p class="mb-0"><b>Correo:</b> <?php echo $consulta['email']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="w-75 ms-0 d-flex justify-content-center">
                                        <div class="w-100 pb-3 pt-3">
                                            <p class="mb-0"><b>Leído:</b> <?php echo $consulta['leido']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="w-75 ms-0 d-flex justify-content-center">
                                        <div class="w-100 pb-3 pt-3">
                                            <p class="mb-0"><b>Consulta:</b> <?php echo $consulta['consulta']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>