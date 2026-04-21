<?php 
    $sesion = session();
    $nombre = $sesion->get('nombre');
    $perfil = $sesion->get('perfil_id');
?>

<footer class="border">
    <?php if($perfil == 2 || $perfil != 1): ?>
    <div class="container text-center pb-2 border-bottom">
        <div class="row ps-5 pe-5 pt-2">
            <div class="col-xl-3 col-lg-12 col-md-12 d-flex justify-content-center">
                <a href="<?php echo base_url('/'); ?>"><img src="<?= base_url('assets/img/LogodelaEmpresa.jpg'); ?>" alt="Logo" width="260px" height="144px"></a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <p class="text-center"><b>Atención al cliente:</b><br><span class="opacity-75">+54 9 3794 04 6207<br>+54 9 3794 91 6905</span></p>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <p class="text-center"><b>Horario de Atención:</b><br><span class="opacity-75">LU-VI de 09:00 a 18:00<br>SA de 9:00 a 13:00</span></p>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12">
                <div>
                    <p class="text-center"><b>Redes Sociales</b></p>
                </div>
                <div class="row d-flex justify-content-center"><br>
                    <div class="col-3 bg-dark-subtle ms-4 me-4 rounded-4 d-flex justify-content-center" style="width: 34px;">
                        <a href="https://www.facebook.com/profile.php?id=61575442171552" target="_blank"><img src="<?= base_url('assets/img/icons8-facebook-30.png'); ?>" alt="Facebook" width="34px" class="p-1 conteiner__footer-img-1"></a>
                    </div>
                    <div class="col-3 bg-dark-subtle ms-4 me-4 rounded-4 d-flex justify-content-center" style="width: 34px;">
                        <a href="https://www.instagram.com/netshop793/" target="_blank"><img src="<?= base_url('assets/img/icons8-instagram-50.png'); ?>" alt="Instagram" width="34px" class="p-1 conteiner__footer-img-1"></a>
                    </div>
                    <div class="col-3 bg-dark-subtle ms-4 me-4 rounded-4 d-flex justify-content-center" style="width: 34px;">
                        <a href="https://x.com/NetShop146710" target="_blank"><img src="<?= base_url('assets/img/icons8-x-30.png'); ?>" alt="X" width="34px" class="p-1 conteiner__footer-img-1"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center border-bottom">
        <div class="row ps-5 pe-5 pt-2 justify-content-center">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 text-center">
                <ul class="list-unstyled">
                    <li><b>Marcas</b></li>
                    <?php foreach($marcas as $marca): ?>
                        <?php if($marca['activo'] == 1): ?>
                            <li class="opacity-75"><?php echo $marca['descripcion']; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 text-center">
                <ul class="list-unstyled">
                    <li><b>Acerca de</b></li>
                    <li><a href="<?php echo base_url('quienesSomos'); ?>" class="text-dark text-decoration-none opacity-75">Quienes Somos</a></li>
                    <li><a href="<?php echo base_url('comercializacion'); ?>" class="text-dark text-decoration-none opacity-75">Comercializacion</a></li>
                    <li><a href="<?php echo base_url('terminosUsos'); ?>" class="text-dark text-decoration-none opacity-75">Términos y Usos</a></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 text-center">
                <ul class="list-unstyled">
                    <li><b>Ayuda</b></li>
                    <li><a href="<?php echo base_url('ayuda#comprar'); ?>" class="text-dark text-decoration-none opacity-75">Comprar</a></li>
                    <li><a href="<?php echo base_url('contacto'); ?>" class="text-dark text-decoration-none opacity-75">Contacto</a></li>
                    <li><a href="<?php echo base_url('ayuda#sucursal'); ?>" class="text-dark text-decoration-none opacity-75">Sucursales</a></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-6 text-center d-none">
                <ul class="list-unstyled">
                    <li><b>¿Preguntas o Comentarios?</b></li>
                    <li><a href="<?php echo base_url('consultas'); ?>" class="text-dark text-decoration-none opacity-75">Consultas</a></li>
                </ul>
            </div>
        </div>
    </div>

    <p class="text-center opacity-75 pt-3">&copy; 2026 NetShop | Todos los derechos reservados | País: Argentina | Provincia: Corrientes | Localidad: Corrientes Capital</p>
    <?php endif; ?>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
</footer>
</body>
</html>