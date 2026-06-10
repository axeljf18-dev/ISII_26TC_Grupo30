<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// VISTA DEL CLIENTE o USUARIO
$routes->get('/', 'Home::inicio', ['filter' => 'adminAuth']);
$routes->get('/productos', 'Home::listarProductos', ['filter' => 'adminAuth']);
$routes->get('/categoria/(:num)', 'Home::listarProductosPorCategoria/$1', ['filter' => 'adminAuth']);
$routes->get('/marca/(:num)', 'Home::listarProductosPorMarca/$1', ['filter' => 'adminAuth']);
$routes->get('/ayuda', 'Home::ayuda', ['filter' => 'adminAuth']);
$routes->get('/contacto', 'Home::contacto', ['filter' => 'adminAuth']);
$routes->get('/quienesSomos', 'Home::quienesSomos', ['filter' => 'adminAuth']);
$routes->get('/comercializacion', 'Home::comercializacion', ['filter' => 'adminAuth']);
$routes->get('/terminosUsos', 'Home::terminosUsos', ['filter' => 'adminAuth']);

// Filtros de Productos
$routes->get('/enviar-formQuery', 'Home::buscador', ['filter' => 'adminAuth']);
$routes->get('/enviar-formPrecio', 'Home::buscarPorRangoPrecioProductos', ['filter' => 'adminAuth']);
$routes->get('/enviar-formPrecioMarca/(:num)', 'Home::buscarPorRangoPrecioMarca/$1', ['filter' => 'adminAuth']);
$routes->get('/enviar-formPrecioCategoria/(:num)', 'Home::buscarPorRangoPrecioCategoria/$1', ['filter' => 'adminAuth']);
$routes->get('/enviar-formPrecioBuscador/(:any)', 'Home::buscarPorRangoPrecioBuscador/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMayor', 'Home::ordenarProductosPorMayorPrecioProductos', ['filter' => 'adminAuth']);
$routes->get('/productosMenor', 'Home::ordenarProductosPorMenorPrecioProductos', ['filter' => 'adminAuth']);
$routes->get('/productosMayorPrecioMarca/(:num)', 'Home::ordenarProductosPorMayorPrecioMarca/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMenorPrecioMarca/(:num)', 'Home::ordenarProductosPorMenorPrecioMarca/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMayorPrecioCategoria/(:num)', 'Home::ordenarProductosPorMayorPrecioCategoria/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMenorPrecioCategoria/(:num)', 'Home::ordenarProductosPorMenorPrecioCategoria/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMayorPrecioBuscador/(:any)', 'Home::ordenarProductosPorMayorPrecioBuscador/$1', ['filter' => 'adminAuth']);
$routes->get('/productosMenorPrecioBuscador/(:any)', 'Home::ordenarProductosPorMenorPrecioBuscador/$1', ['filter' => 'adminAuth']);

// Registro y Inicio de sesión
$routes->get('/registrarse', 'Usuario_controller::mostrarFormularioRegistrarse', ['filter' => 'auth']);
$routes->post('/enviar-form', 'Usuario_controller::recibirDatosFormularioUsuario', ['filter' => 'auth']);
$routes->get('/limpiarUsuario', 'Usuario_controller::limpiarDatosFormularioUsuario/registro', ['filter' => 'auth']);
$routes->get('/inicioSesion', 'Login_controller::mostrarFormularioLogin', ['filter' => 'auth']);
$routes->post('/enviar-login', 'Login_controller::recibirDatosFormularioLogin', ['filter' => 'auth']);
$routes->get('/limpiarSesion', 'Login_controller::limpiarDatosFormularioLogin', ['filter' => 'auth']);
$routes->get('/cerrarSesion', 'Login_controller::cerrarSesion');

// Vista del Carrito
$routes->get('/carrito', 'Carrito_controller::mostrarCarrito', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->post('/enviar-formCarritoAgregar/(:num)', 'Carrito_controller::add/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/borrar-producto/(:any)', 'Carrito_controller::eliminarProducto/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/borrar-carrito', 'Carrito_controller::eliminarCarrito', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/suma-carrito/(:any)', 'Carrito_controller::suma/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/resta-carrito/(:any)', 'Carrito_controller::resta/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->post('/comprar-carrito', 'VentaCabecera_controller::recibirDatosDeLaVenta', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->post('/enviar-formActualizaCarrito', 'Carrito_controller::update', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/misCompras', 'VentaCabecera_controller::mostrarMisComprasCliente', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/vistaDetalleCompra/(:num)', 'VentaDetalle_controller::mostrarDetalleVenta/$1', ['filter' => ['adminAuth', 'carritoAuth']]);



// VISTA DEL ADMINISTRADOR
// Vista de Usuarios
$routes->get('/mostrarListaUsuarios', 'Usuario_controller::listarUsuarios/activos', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaUsuariosDesactivados', 'Usuario_controller::listarUsuarios/desactivados', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaUsuariosActualizarEliminar', 'Usuario_controller::listarUsuarios/actualizarEliminar', ['filter' => 'usuarioAuth']);
$routes->get('/altaDeUsuarios', 'Usuario_controller::mostrarFormularioCrearUsuario', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuario', 'Usuario_controller::recibirDatosFormularioUsuario', ['filter' => 'usuarioAuth']);
$routes->get('/actualizarUsuarios/(:num)', 'Usuario_controller::mostrarFormularioActualizarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioActualizar', 'Usuario_controller::recibirDatosFormularioUsuario', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarMensajeConfirmacionUsuario/(:num)/(:any)', 'Usuario_controller::mostrarMensajeConfirmacionUsuario/$1/$2', ['filter' => 'usuarioAuth']);
$routes->get('/eliminarUsuarios/(:num)', 'Usuario_controller::darDeBajaUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->get('/activarUsuarios/(:num)', 'Usuario_controller::habilitarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarUsuarioUser', 'Usuario_controller::limpiarDatosFormularioUsuario/altaUsuario', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarUsuarioUserAct/(:num)', 'Usuario_controller::limpiarDatosFormularioUsuario/actualizarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formUsuarioQuery', 'Usuario_controller::buscarUsuarios/activos', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formUsuarioDesactivadoQuery', 'Usuario_controller::buscarUsuarios/desactivados', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formUsuarioActQuery', 'Usuario_controller::buscarUsuarios/actualizarEliminar', ['filter' => 'usuarioAuth']);

// Vista de Productos
$routes->get('/mostrarListaProductos', 'Producto_controller::listarProductos/activos', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaProductosDesactivados', 'Producto_controller::listarProductos/desactivados', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaProductosActualizarEliminar', 'Producto_controller::listarProductos/actualizarEliminar', ['filter' => 'usuarioAuth']);
$routes->get('/altaDeProductos', 'Producto_controller::mostrarFormularioCrearProducto', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProducto', 'Producto_controller::recibirDatosFormularioProducto', ['filter' => 'usuarioAuth']);
$routes->get('/actualizarProductos/(:num)', 'Producto_controller::mostrarFormularioActualizarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoActualizar', 'Producto_controller::recibirDatosFormularioProducto', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarMensajeConfirmacionProducto/(:num)/(:any)', 'Producto_controller::mostrarMensajeConfirmacion/$1/$2', ['filter' => 'usuarioAuth']);
$routes->get('/eliminarProductos/(:num)', 'Producto_controller::desactivarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->get('/activarProductos/(:num)', 'Producto_controller::reactivarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarProducto', 'Producto_controller::limpiarDatosFormularioProducto', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarProductoAct/(:num)', 'Producto_controller::limpiarDatosFormularioProducto/$1', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formProductoQuery', 'Producto_controller::buscarProductos/activos', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formProductoDesactivadoQuery', 'Producto_controller::buscarProductos/desactivados', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formProductoActQuery', 'Producto_controller::buscarProductos/actualizarEliminar', ['filter' => 'usuarioAuth']);

// Vista de Ventas
$routes->get('/mostrarListaVentas', 'VentaCabecera_controller::mostrarVentasAdmin', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarDetalleCompraCliente/(:num)', 'VentaDetalle_controller::mostrarDetalleVenta/$1', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formFechaQuery', 'VentaCabecera_controller::mostrarVentasPorFechasAdmin', ['filter' => 'usuarioAuth']);
$routes->get('/enviar-formFechaQuery20', 'VentaCabecera_controller::mostrarComprasPorFechasCliente', ['filter' => ['adminAuth', 'carritoAuth']]);