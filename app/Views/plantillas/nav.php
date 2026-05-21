<?php 
    $sesion = session();
    $id = $sesion->get('id_usuario');
    $usuario = $sesion->get('usuario');
    $perfil = $sesion->get('id_perfil');
?>

<div class="bg-white">
    <nav class="pt-1">
        <div class="row border-bottom ms-0 me-0">
            <?php if($perfil == 2): ?>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 ps-0 pe-0 d-flex justify-content-center">
                    <a href="<?php echo base_url('/'); ?>"><img src="<?= base_url('assets/img/LogodelaEmpresa.jpg'); ?>" alt="Logo" width="200px" height="80px"></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 ps-0 pe-0 d-flex justify-content-center">
                    <?php echo $this->include('plantillas/search')?>
                </div>
            <?php elseif($perfil != 2 && $perfil != 1): ?>
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 ps-0 pe-0 d-flex justify-content-center">
                    <a href="<?php echo base_url('/'); ?>"><img src="<?= base_url('assets/img/LogodelaEmpresa.jpg'); ?>" alt="Logo" width="200px" height="80px"></a>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 ps-0 pe-0 d-flex justify-content-center">
                    <?php echo $this->include('plantillas/search')?>
                </div>
            <?php endif; ?>

            <ul class="col-xl-4 col-lg-4 col-md-4 col-sm-12 nav nav-tabs pe-0 d-flex justify-content-center align-items-center contenedor__nav">
                <?php if($perfil == 1): ?>
                    <div class="dropdown contenedor__a-categorias">
                        <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><b>Administrador: <?php echo $usuario; ?></b></a> 
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('cerrarSesion'); ?>"><b>Cerrar Sesión</b></a></li>
                        </ul>
                    </div>
                <?php elseif($perfil == 2): ?>
                    <div class="dropdown contenedor__a-categorias">
                        <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><b>Usuario: <?php echo $usuario; ?></b></a> 
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('misCompras'); ?>"><b>Mis Compras</b></a></li>
                            <li><a class="dropdown-item border-top item__li-a-3" href="<?php echo base_url('cerrarSesion'); ?>"><b>Cerrar Sesión</b></a></li>
                        </ul>
                    </div>
                    <li class="nav-item">
                        <a class="nav-link item__li-a-1" href="<?php echo base_url('carrito'); ?>"><img src="<?= base_url('assets/img/carro-vacio.png'); ?>" alt="Carrito" width="20px" class="contenedor__nav-li-a-img-1"></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark opacity-75" href="<?php echo base_url('inicioSesion'); ?>">Inicio de Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="navbar navbar-expand-lg navbar-dark border-bottom">
            <div class="container-fluid d-flex justify-content-center contenedor__nav-div-2">
                <?php if($perfil == 1): ?>
                    <div>
                        <div class="dropdown contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Agregar</b>
                            </a> 
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('altaDeProductos'); ?>"><b>Producto</b></a></li>
                                <!-- display:none; -->
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('altaDeCategorias'); ?>"><b>Categoria</b></a></li>
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('altaDeUsuarios'); ?>"><b>Usuario</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('altaDePerfiles'); ?>"><b>Perfil</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('altaDeMarcas'); ?>"><b>Marca</b></a></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Mostrar</b>
                            </a> 
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaProductos'); ?>"><b>Lista de Productos</b></a></li>
                                <!-- display:none; -->
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaCategorias'); ?>"><b>Lista de Categorias</b></a></li>
                                <li ><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaUsuarios'); ?>"><b>Lista de Usuarios</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaPerfiles'); ?>"><b>Lista de Perfiles</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaMarcas'); ?>"><b>Lista de Marcas</b></a></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Actualizar o Eliminar</b>
                            </a> 
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaProductosActualizarEliminar'); ?>"><b>Producto</b></a></li>
                                <!-- display:none; -->
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaCategoriasActualizarEliminar'); ?>"><b>Categoria</b></a></li>
                                <li ><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaUsuariosActualizarEliminar'); ?>"><b>Usuario</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaPerfilesActualizarEliminar'); ?>"><b>Perfil</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaMarcasActualizarEliminar'); ?>"><b>Marca</b></a></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Más Información</b>
                            </a> 
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaVentas'); ?>"><b>Ventas</b></a></li>
                                <li style="display:none;"><a class="dropdown-item item__li-a-3" href="<?php echo base_url('mostrarListaConsultas'); ?>"><b>Consultas</b></a></li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <div>
                        <div class="dropdown d-flex align-items-center contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Más Información</b>
                            </a> 
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('quienesSomos'); ?>"><b>Quienes Somos</b></a></li>
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('comercializacion'); ?>"><b>Comercializacion</b></a></li>
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('terminosUsos'); ?>"><b>Términos y Usos</b></a></li>
                                <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('ayuda'); ?>"><b>Ayuda</b></a></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown d-flex align-items-center contenedor__a-categorias">
                            <a class="btn item__li-a-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= base_url('assets/img/hamburger.png'); ?>" alt="Hamburguesa" width="12px" height="12px" class="me-0 mb-1 contenedor__nav-li-a-img-2">
                                <b>Categorías</b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach($categorias as $categoria): ?>
                                    <?php if($categoria['activo'] == 1): ?>
                                        <li><a class="dropdown-item item__li-a-3" href="<?php echo base_url('categoria/' . $categoria['id_categoria']); ?>"><b><?php echo $categoria['descripcion']; ?></b></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <ul class="nav nav-tabs d-flex justify-content-end align-items-center contenedor__nav">
                            <li class="nav-item">
                                <a class="nav-link item__li-a-1" href="<?php echo base_url('productos'); ?>"><b>Productos</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link item__li-a-1" href="<?php echo base_url('contacto'); ?>"><b>Contacto</b></a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link item__li-a-1" href="<?php echo base_url('consultas'); ?>"><b>Consultas</b></a>
                            </li> -->
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</div>