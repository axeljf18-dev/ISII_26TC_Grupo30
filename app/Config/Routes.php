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

// // Consulta
// $routes->get('/consultas', 'Home::consultas', ['filter' => 'adminAuth']);
// $routes->post('/enviar-formConsulta', 'Consulta_controller::formValidation', ['filter' => 'adminAuth']);
// $routes->get('/limpiarConsulta', 'Consulta_controller::limpiarDatos', ['filter' => 'adminAuth']);

// Registro y Inicio de sesión
$routes->get('/registrarse', 'Usuario_controller::registrarse', ['filter' => 'auth']);
$routes->post('/enviar-form', 'Usuario_controller::formValidation', ['filter' => 'auth']);
$routes->get('/inicioSesion', 'Login_controller::inicioSesion', ['filter' => 'auth']);
$routes->post('/enviar-login', 'Login_controller::formValidation', ['filter' => 'auth']);
$routes->get('/limpiarUsuario', 'Usuario_controller::limpiarDatos', ['filter' => 'auth']);
$routes->get('/limpiarSesion', 'Login_controller::limpiarDatos', ['filter' => 'auth']);
$routes->get('/cerrarSesion', 'Login_controller::logeout');

// Vista del Carrito
$routes->get('/carrito', 'Home::carrito', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->post('/enviar-formCarritoAgregar/(:num)', 'Carrito_controller::add/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/borrar-producto/(:any)', 'Carrito_controller::eliminarProducto/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/borrar-carrito', 'Carrito_controller::eliminarCarrito', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/suma-carrito/(:any)', 'Carrito_controller::suma/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/resta-carrito/(:any)', 'Carrito_controller::resta/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->post('/comprar-carrito', 'Venta_controller::registrarVenta', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/vistaDetalleCompra/(:num)', 'Venta_controller::verFactura/$1', ['filter' => ['adminAuth', 'carritoAuth']]);
$routes->get('/misCompras', 'Venta_controller::misCompras', ['filter' => ['adminAuth', 'carritoAuth']]);

$routes->post('/enviar-formActualizaCarrito', 'Carrito_controller::update', ['filter' => ['adminAuth', 'carritoAuth']]);



// VISTA DEL ADMINISTRADOR
// Vista de Usuarios
$routes->get('/mostrarListaUsuarios', 'Usuario_controller::listaUsuarios', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaUsuariosDesactivados', 'Usuario_controller::indexDesactivados', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaUsuariosParaActivar', 'Usuario_controller::indexParaActivar', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaUsuariosActualizarEliminar', 'Usuario_controller::indexActualizarEliminar', ['filter' => 'usuarioAuth']);
$routes->get('/altaDeUsuarios', 'Usuario_controller::crearUsuario', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuario', 'Usuario_controller::formValidationUsuario', ['filter' => 'usuarioAuth']);
$routes->get('/actualizarUsuarios/(:num)', 'Usuario_controller::actualizarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioActualizar', 'Usuario_controller::formValidationUpdate', ['filter' => 'usuarioAuth']);
$routes->get('/eliminarUsuarios/(:num)', 'Usuario_controller::eliminarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->get('/activarUsuarios/(:num)', 'Usuario_controller::activarUsuario/$1', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarUsuarioUser', 'Usuario_controller::limpiarDatosUser', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarUsuarioUserAct/(:num)', 'Usuario_controller::limpiarDatosUserAct/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioQuery', 'Usuario_controller::buscadorUsuarios', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioDesactivadoQuery', 'Usuario_controller::buscadorUsuariosDesactivados', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioActQuery', 'Usuario_controller::buscadorUsuariosAct', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formUsuarioParaActivarQuery', 'Usuario_controller::buscadorUsuariosParaActivar', ['filter' => 'usuarioAuth']);

// Vista de Productos
$routes->get('/mostrarListaProductos', 'Producto_controller::listarProductos', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaProductosDesactivados', 'Producto_controller::listarProductosDesactivados', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaProductosParaActivar', 'Producto_controller::listarProductosParaActivar', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaProductosActualizarEliminar', 'Producto_controller::listarProductosParaActualizarEliminar', ['filter' => 'usuarioAuth']);
$routes->get('/altaDeProductos', 'Producto_controller::mostrarFormularioCrearProducto', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProducto', 'Producto_controller::validarDatosProducto', ['filter' => 'usuarioAuth']);
$routes->get('/actualizarProductos/(:num)', 'Producto_controller::mostrarFormularioActualizarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoActualizar', 'Producto_controller::validarDatosProductoUpdate', ['filter' => 'usuarioAuth']);
$routes->get('/eliminarProductos/(:num)', 'Producto_controller::desactivarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->get('/activarProductos/(:num)', 'Producto_controller::reactivarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarProducto', 'Producto_controller::limpiarFormularioAltaProducto', ['filter' => 'usuarioAuth']);
$routes->get('/limpiarProductoAct/(:num)', 'Producto_controller::limpiarFormularioActualizarProducto/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoQuery', 'Producto_controller::buscarProductosActivos', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoDesactivadoQuery', 'Producto_controller::buscarProductosDesactivados', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoActQuery', 'Producto_controller::buscarProductosParaActualizarEliminar', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formProductoParaActivarQuery', 'Producto_controller::buscarProductosParaActivar', ['filter' => 'usuarioAuth']);

// // Vista de Perfiles
// $routes->get('/mostrarListaPerfiles', 'Perfil_controller::index', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaPerfilesDesactivados', 'Perfil_controller::indexDesactivados', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaPerfilesParaActivar', 'Perfil_controller::indexParaActivar', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaPerfilesActualizarEliminar', 'Perfil_controller::indexActualizarEliminar', ['filter' => 'usuarioAuth']);
// $routes->get('/altaDePerfiles', 'Perfil_controller::crearPerfil', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formPerfil', 'Perfil_controller::formValidation', ['filter' => 'usuarioAuth']);
// $routes->get('/actualizarPerfiles/(:num)', 'Perfil_controller::actualizarPerfil/$1', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formPerfilActualizar', 'Perfil_controller::formValidationUpdate', ['filter' => 'usuarioAuth']);
// $routes->get('/eliminarPerfiles/(:num)', 'Perfil_controller::eliminarPerfil/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/activarPerfiles/(:num)', 'Perfil_controller::activarPerfil/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarPerfil', 'Perfil_controller::limpiarDatos', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarPerfilAct/(:num)', 'Perfil_controller::limpiarDatosAct/$1', ['filter' => 'usuarioAuth']);

// // Vista de Categorias
// $routes->get('/mostrarListaCategorias', 'Categoria_controller::index', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaCategoriasDesactivados', 'Categoria_controller::indexDesactivados', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaCategoriasParaActivar', 'Categoria_controller::indexParaActivar', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaCategoriasActualizarEliminar', 'Categoria_controller::indexActualizarEliminar', ['filter' => 'usuarioAuth']);
// $routes->get('/altaDeCategorias', 'Categoria_controller::crearCategoria', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formCategoria', 'Categoria_controller::formValidation', ['filter' => 'usuarioAuth']);
// $routes->get('/actualizarCategorias/(:num)', 'Categoria_controller::actualizarCategoria/$1', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formCategoriaActualizar', 'Categoria_controller::formValidationUpdate', ['filter' => 'usuarioAuth']);
// $routes->get('/eliminarCategorias/(:num)', 'Categoria_controller::eliminarCategoria/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/activarCategorias/(:num)', 'Categoria_controller::activarCategoria/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarCategoria', 'Categoria_controller::limpiarDatos', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarCategoriaAct/(:num)', 'Categoria_controller::limpiarDatosAct/$1', ['filter' => 'usuarioAuth']);

// // Vista de Marcas
// $routes->get('/mostrarListaMarcas', 'Marca_controller::index', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaMarcasDesactivados', 'Marca_controller::indexDesactivados', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaMarcasParaActivar', 'Marca_controller::indexParaActivar', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaMarcasActualizarEliminar', 'Marca_controller::indexActualizarEliminar', ['filter' => 'usuarioAuth']);
// $routes->get('/altaDeMarcas', 'Marca_controller::crearMarca', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formMarca', 'Marca_controller::formValidation', ['filter' => 'usuarioAuth']);
// $routes->get('/actualizarMarcas/(:num)', 'Marca_controller::actualizarMarca/$1', ['filter' => 'usuarioAuth']);
// $routes->post('/enviar-formMarcaActualizar', 'Marca_controller::formValidationUpdate', ['filter' => 'usuarioAuth']);
// $routes->get('/eliminarMarcas/(:num)', 'Marca_controller::eliminarMarca/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/activarMarcas/(:num)', 'Marca_controller::activarMarca/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarMarca', 'Marca_controller::limpiarDatos', ['filter' => 'usuarioAuth']);
// $routes->get('/limpiarMarcaAct/(:num)', 'Marca_controller::limpiarDatosAct/$1', ['filter' => 'usuarioAuth']);

// Vista de Ventas
$routes->get('/mostrarListaVentas', 'Venta_controller::index', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarListaVentasDesactivadas', 'Venta_controller::indexDesactivadas', ['filter' => 'usuarioAuth']);
$routes->get('/mostrarDetalleCompraCliente/(:num)', 'Venta_controller::indexDetalleCompra/$1', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formFechaQuery', 'Venta_controller::buscadorVentas', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formFechaDesactivadoQuery', 'Venta_controller::buscadorVentasDesactivados', ['filter' => 'usuarioAuth']);
$routes->post('/enviar-formFechaQuery20', 'Venta_controller::buscadorVentasDeUnCliente', ['filter' => ['adminAuth', 'carritoAuth']]);


// // Vista de Consultas
// $routes->get('/mostrarListaConsultas', 'Consulta_controller::index', ['filter' => 'usuarioAuth']);
// $routes->get('/mostrarListaConsultasDesactivadas', 'Consulta_controller::indexDesactivadas', ['filter' => 'usuarioAuth']);
// $routes->get('/marcarConsulta/(:num)', 'Consulta_controller::marcarConsulta/$1', ['filter' => 'usuarioAuth']);
// $routes->get('/eliminarConsulta/(:num)', 'Consulta_controller::eliminarConsulta/$1', ['filter' => 'usuarioAuth']);