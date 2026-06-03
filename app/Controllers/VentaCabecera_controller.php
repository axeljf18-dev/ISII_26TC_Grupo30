<?php
namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Marca_model;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\models\Usuarios_model;
use App\Models\VentaCabecera_model;
use App\models\VentaDetalle_model;
use App\Controllers\Carrito_controller;
// use App\Services\CarritoService;

class VentaCabecera_controller extends Controller{
    // public function registrarVenta(){
    //     $session = session();

    //     $request = \Config\Services::request();
    //     $idMetodoPago = $request->getPost('id_metodo_pago');

    //     if (empty($idMetodoPago)) {
    //         $session->setFlashdata('mensaje', 'Debe seleccionar un método de pago válido');
    //         return redirect()->to('/carrito');
    //     }

    //     require(APPPATH . 'Controllers/Carrito_controller.php');
    //     $cartController = new Carrito_controller();
    //     $carritoContents = $cartController->devolverCarrito();

    //     $productoModel = new Producto_model();
    //     $ventasModel = new VentaCabecera_model();
    //     $detalleModel = new VentaDetalle_model();

    //     $productosValidos = [];
    //     $productosSinStock = [];
    //     $total = 0;

    //     // Validar stock y filtrar productos válidos
    //     foreach ($carritoContents as $item) {
    //         $producto = $productoModel->getProducto($item['id']);
    //         if ($producto && $producto['stock'] >= $item['qty']) {
    //             $productosValidos[] = $item;
    //             $total += $item['subtotal'];
    //         } else {
    //             $productosSinStock[] = $item['name']; // Eliminar del carrito el producto sin stock
    //             $cartController->eliminarProducto($item['rowid']);
    //         }
    //     }
        
    //     // Si hay productos sin stock, avisar y volver al carrito
    //     if (!empty($productosSinStock)) {
    //         $mensaje = 'Los siguientes productos: ' . implode(', ', $productosSinStock) . '. No tienen stock suficiente y fueron eliminados de "Mi Carrito"';
    //         $session->setFlashdata('mensaje', $mensaje);
    //         return redirect()->to('/carrito');
    //     }
        
    //     // Si no hay productos válidos, no se registra la venta
    //     if (empty($productosValidos)) {
    //         $session->setFlashdata('mensaje', 'No hay productos válidos para registrar la venta');
    //         return redirect()->to('/carrito');
    //     }
        
    //     // Registrar la venta en las tablas Venta_cabecera y Venta_detalle
    //     // Registrar cabecera de la venta
    //     $nuevaVenta = [
    //         'id_usuario'  => $session->get('id_usuario'),
    //         'id_metodo_pago' => $idMetodoPago,
    //         'total_venta' => $total
    //     ];
    //     $ventaId = $ventasModel->insert($nuevaVenta);
        
    //     // Registrar detalle y actualizar stock
    //     foreach ($productosValidos as $item) {
    //         $detalle = [
    //             'id_venta_cabecera'    => $ventaId,
    //             'id_producto' => $item['id'],
    //             'cantidad'    => $item['qty'],
    //             'precio'      => $item['price']
    //         ];
    //         $detalleModel->insert($detalle);
    //         $producto = $productoModel->getProducto($item['id']);
    //         $productoModel->updateStock($item['id'], $producto['stock'] - $item['qty']);
    //     }
        
    //     // Vaciar carrito y mostrar confirmación
    //     $cartController->eliminarCarrito();
    //     $session->setFlashdata('mensajeVenta', 'Venta registrada exitosamente');
    //     return redirect()->to(base_url('vistaDetalleCompra/' . $ventaId));
    // }

    public function validarVenta(){
        $session = session();
        $request = \Config\Services::request();
        $idMetodoPago = $request->getPost('id_metodo_pago');
        // $cartController = new Carrito_controller();

        // require(APPPATH . 'Controllers/Carrito_controller.php');
        $cartController = new Carrito_controller();
        $carritoContents = $cartController->devolverCarrito();

        // $carritoService = new CarritoService();
        // $carritoContents = $carritoService->devolverCarrito();

        $productoModel = new Producto_model();
        $productosValidos = [];
        $productosSinStock = [];
        $total = 0;

        // Validar método de pago
        if (empty($idMetodoPago)) {
            $session->setFlashdata('mensaje', 'Debe seleccionar un método de pago válido');
            return redirect()->to('/carrito');
        }

        // Validar stock
        foreach ($carritoContents as $item) {
            $producto = $productoModel->getProducto($item['id']);
            if ($producto && $producto['stock'] >= $item['qty']) {
                $productosValidos[] = $item;
                $total += $item['subtotal'];
            } else {
                $productosSinStock[] = $item['name'];
                $cartController->eliminarProducto($item['rowid']);
            }
        }

        // Manejo de errores
        if (!empty($productosSinStock)) {
            $mensaje = 'Los siguientes productos: ' . implode(', ', $productosSinStock) . ' no tienen stock suficiente y fueron eliminados de "Mi Carrito"';
            $session->setFlashdata('mensaje', $mensaje);
            return redirect()->to('/carrito');
        }

        if (empty($productosValidos)) {
            $session->setFlashdata('mensaje', 'No hay productos válidos para registrar la venta');
            return redirect()->to('/carrito');
        }

        // Si todo está bien, entonces llamar a registrarVenta
        return $this->registrarVenta($productosValidos, $idMetodoPago, $total);
    }

    public function registrarVenta($productosValidos, $idMetodoPago, $total){
        $session = session();
        $ventasModel = new VentaCabecera_model();
        $detalleModel = new VentaDetalle_model();
        $productoModel = new Producto_model();

        // Registrar cabecera
        $nuevaVenta = [
            'id_usuario' => $session->get('id_usuario'),
            'id_metodo_pago' => $idMetodoPago,
            'total_venta' => $total
        ];
        $ventaId = $ventasModel->insert($nuevaVenta);

        // Registrar detalle y actualizar stock
        foreach ($productosValidos as $item) {
            $detalle = [
                'id_venta_cabecera' => $ventaId,
                'id_producto' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['price']
            ];
            $detalleModel->insert($detalle);

            $producto = $productoModel->getProducto($item['id']);
            $productoModel->updateStock($item['id'], $producto['stock'] - $item['qty']);
        }

        // Vaciar carrito y confirmar
        // require(APPPATH . 'Controllers/Carrito_controller.php');
        $cartController = new Carrito_controller();
        $cartController->eliminarCarrito();

        $session->setFlashdata('mensajeVenta', 'Venta registrada exitosamente');
        return redirect()->to(base_url('vistaDetalleCompra/' . $ventaId));
    }

    public function mostrarMisComprasCliente(){ 
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->getUsuarioAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $userId = session()->get('id_usuario');
        $ventasCabeceraModel = new VentaCabecera_model();
        $data['ventas'] = $ventasCabeceraModel->where('id_usuario', $userId)->orderBy('fecha', 'ASC')->paginate(7);
        $data['pager'] = $ventasCabeceraModel->pager;

        $data['titulo'] = "NetShop | Mis Compras";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/misCompras', $data);
        echo view('plantillas/footer', $data);
    }

    public function mostrarComprasPorFechasCliente(){
        $session = session();
        $queryFechaInicio = $this->request->getVar('fechaInicioQuery20');
        $queryFechaFin = $this->request->getVar('fechaFinQuery20'); 

        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->getUsuarioAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $resultadoBusqueda = $this->filtrarComprasCliente($queryFechaInicio, $queryFechaFin);
        $data = array_merge($data, $resultadoBusqueda);

        $data['titulo'] = "NetShop | Mis Compras";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/misCompras', $data);
        echo view('plantillas/footer', $data);
    }

    private function filtrarComprasCliente($queryFechaInicio, $queryFechaFin){
        $session = session();
        $userId = session()->get('id_usuario');
        $ventaModel = new VentaCabecera_model();

        $data = [];
        $fechaFinMasUno = date('Y-m-d', strtotime($queryFechaFin . ' +1 day'));

        if($queryFechaInicio && $queryFechaFin && ($queryFechaInicio <= $queryFechaFin)){ 
            $data['ventas'] = $ventaModel
                ->where('fecha >=', $queryFechaInicio)
                ->where('fecha <', $fechaFinMasUno)
                ->where('id_usuario', $userId)
                ->orderBy('fecha', 'ASC')
                ->paginate(7);

            $data['pager'] = $ventaModel->pager;
        } else {
            $session->setFlashdata('msgFechasIncorrectas', 'Las fechas ingresadas no han generado resultados');
            $data['ventas'] = [];
        }

        $session->setFlashdata('fechaInicioQueryValor20', $queryFechaInicio);
        $session->setFlashdata('fechaFinQueryValor20', $queryFechaFin);

        return $data;
    }

    public function mostrarVentasAdmin(){
        // $usuarioModel = new Usuarios_model();
        // $data['usuarios'] = $usuarioModel->getUsuarioAll();
        $ventasCabeceraModel = new VentaCabecera_model();
        $ventaDetalleModel = new VentaDetalle_model();
        $data['ventas'] = $ventasCabeceraModel->getVentasCabeceraPaginadas(7, 'DESC');
        $data['pager'] = $ventasCabeceraModel->pager;

        // Para el PDF (todas las ventas)
        $data['ventasPdf'] = $ventasCabeceraModel
            ->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, producto.nombre as producto_nombre, venta_detalle.cantidad, venta_detalle.precio, 
                    (venta_detalle.cantidad * venta_detalle.precio) as subtotal")
            ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
            ->join('venta_detalle', 'venta_detalle.id_venta_cabecera = venta_cabecera.id_venta_cabecera')
            ->join('producto', 'producto.id_producto = venta_detalle.id_producto')
            ->orderBy('fecha', 'ASC')
            ->findAll();

        // // Para el resumen (todas las ventas)
        // $todasLasVentas = $ventasCabeceraModel->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, metodo_pago.nombre as metodo_pago_nombre")->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta_cabecera.id_metodo_pago')->orderBy('fecha', 'ASC')->findAll();

        // if (!empty($todasLasVentas)) {
        //     $totales = array_column($todasLasVentas, 'total_venta');
        //     $clientes = array_column($todasLasVentas, 'usuario_nombre');

        //     $cantidadVentas = count($totales);
        //     $cantidadClientes = count(array_unique($clientes));
        //     $ventaMax = max($totales);
        //     $ventaMin = min($totales);
        //     $promedioFactura = array_sum($totales) / $cantidadVentas;
        //     $totalVentas = array_sum($totales);

        //     // Cliente más frecuente
        //     $conteoClientes = array_count_values($clientes);
        //     arsort($conteoClientes);
        //     $clienteFrecuente = key($conteoClientes);

        //     // Día con mayor facturación
        //     $ventasPorDia = [];
        //     foreach ($todasLasVentas as $venta) {
        //         $ventasPorDia[$venta['fecha']] = ($ventasPorDia[$venta['fecha']] ?? 0) + $venta['total_venta'];
        //     }
        //     arsort($ventasPorDia);
        //     $diaMayorFacturacion = key($ventasPorDia);
        //     $montoDiaMayor = current($ventasPorDia);

        //     // Método de pago más usado
        //     $metodosPago = array_column($todasLasVentas, 'metodo_pago_nombre');
        //     $conteoMetodos = array_count_values($metodosPago);
        //     arsort($conteoMetodos);
        //     $metodoMasUsado = key($conteoMetodos);
        //     $cantidadMetodoMasUsado = current($conteoMetodos);

        //     // Producto más vendido (requiere recorrer detalles)
        //     $detalles = $ventaDetalleModel->select('venta_detalle.*, producto.nombre as producto_nombre')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->findAll();
        //     $productosVendidos = array_column($detalles, 'producto_nombre');
        //     $conteoProductos = array_count_values($productosVendidos);
        //     arsort($conteoProductos);
        //     $productoMasVendido = key($conteoProductos);
        //     $cantidadProductoMasVendido = current($conteoProductos);

        //     // Cliente con mayor facturación
        //     $ventasPorCliente = [];
        //     foreach ($todasLasVentas as $venta) {
        //         $ventasPorCliente[$venta['usuario_nombre']] =
        //             ($ventasPorCliente[$venta['usuario_nombre']] ?? 0) + $venta['total_venta'];
        //     }
        //     arsort($ventasPorCliente);
        //     $clienteMayorFacturacion = key($ventasPorCliente);
        //     $montoClienteMayor = current($ventasPorCliente);

        //     $data['resumen'] = [
        //         'cantidadVentas'            => $cantidadVentas,
        //         'cantidadClientes'          => $cantidadClientes,
        //         'ventaMax'                  => $ventaMax,
        //         'ventaMin'                  => $ventaMin,
        //         'promedioFactura'           => $promedioFactura,
        //         'clienteFrecuente'          => $clienteFrecuente,
        //         'diaMayorFacturacion'       => $diaMayorFacturacion,
        //         'montoDiaMayor'             => $montoDiaMayor,
        //         'totalVentas'               => $totalVentas,
        //         'metodoMasUsado'            => $metodoMasUsado,
        //         'cantidadMetodoMasUsado'    => $cantidadMetodoMasUsado,
        //         'productoMasVendido'        => $productoMasVendido,
        //         'cantidadProductoMasVendido'=> $cantidadProductoMasVendido,
        //         'clienteMayorFacturacion'   => $clienteMayorFacturacion,
        //         'montoClienteMayor'         => $montoClienteMayor,
        //     ];

        //     // Datos para los gráficos
        //     // Evolución temporal
        //     $ventasPorMes = [];
        //     foreach ($todasLasVentas as $venta) {
        //         $mes = date('F', strtotime($venta['fecha']));
        //         $ventasPorMes[$mes] = ($ventasPorMes[$mes] ?? 0) + $venta['total_venta'];
        //     }
        //     $data['ventasPorMes'] = $ventasPorMes;

        //     // Distribución por cliente
        //     $data['clientes'] = array_keys($conteoClientes);
        //     $data['ventasPorCliente'] = array_values($conteoClientes);

        //     // Ventas por producto
        //     $data['productos'] = array_keys($conteoProductos);
        //     $data['ventasPorProducto'] = array_values($conteoProductos);
        // }

        $resumen = $this->calcularResumenVentasAdmin($ventasCabeceraModel, $ventaDetalleModel);
        $data = array_merge($data, $resumen);

        $data['titulo'] = "Dashboard | Lista de Ventas";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav');
        echo view('back/admin/listaVentas', $data);
        echo view('plantillas/footer');
    }

    private function calcularResumenVentasAdmin($ventasCabeceraModel, $ventaDetalleModel){
        // Para el resumen (todas las ventas)
        $todasLasVentas = $ventasCabeceraModel->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, metodo_pago.nombre as metodo_pago_nombre")->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta_cabecera.id_metodo_pago')->orderBy('fecha', 'ASC')->findAll();

        $resultado = [];

        if (!empty($todasLasVentas)) {
            $totales = array_column($todasLasVentas, 'total_venta');
            $clientes = array_column($todasLasVentas, 'usuario_nombre');

            $cantidadVentas = count($totales);
            $cantidadClientes = count(array_unique($clientes));
            $ventaMax = max($totales);
            $ventaMin = min($totales);
            $promedioFactura = array_sum($totales) / $cantidadVentas;
            $totalVentas = array_sum($totales);

            // Cliente más frecuente
            $conteoClientes = array_count_values($clientes);
            arsort($conteoClientes);
            $clienteFrecuente = key($conteoClientes);

            // Día con mayor facturación
            $ventasPorDia = [];
            foreach ($todasLasVentas as $venta) {
                $ventasPorDia[$venta['fecha']] = ($ventasPorDia[$venta['fecha']] ?? 0) + $venta['total_venta'];
            }
            arsort($ventasPorDia);
            $diaMayorFacturacion = key($ventasPorDia);
            $montoDiaMayor = current($ventasPorDia);

            // Método de pago más usado
            $metodosPago = array_column($todasLasVentas, 'metodo_pago_nombre');
            $conteoMetodos = array_count_values($metodosPago);
            arsort($conteoMetodos);
            $metodoMasUsado = key($conteoMetodos);
            $cantidadMetodoMasUsado = current($conteoMetodos);

            // Producto más vendido (requiere recorrer detalles)
            $detalles = $ventaDetalleModel->select('venta_detalle.*, producto.nombre as producto_nombre')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->findAll();
            $productosVendidos = array_column($detalles, 'producto_nombre');
            $conteoProductos = array_count_values($productosVendidos);
            arsort($conteoProductos);
            $productoMasVendido = key($conteoProductos);
            $cantidadProductoMasVendido = current($conteoProductos);

            // Cliente con mayor facturación
            $ventasPorCliente = [];
            foreach ($todasLasVentas as $venta) {
                $ventasPorCliente[$venta['usuario_nombre']] =
                    ($ventasPorCliente[$venta['usuario_nombre']] ?? 0) + $venta['total_venta'];
            }
            arsort($ventasPorCliente);
            $clienteMayorFacturacion = key($ventasPorCliente);
            $montoClienteMayor = current($ventasPorCliente);

            $resultado['resumen'] = [
                'cantidadVentas'            => $cantidadVentas,
                'cantidadClientes'          => $cantidadClientes,
                'ventaMax'                  => $ventaMax,
                'ventaMin'                  => $ventaMin,
                'promedioFactura'           => $promedioFactura,
                'clienteFrecuente'          => $clienteFrecuente,
                'diaMayorFacturacion'       => $diaMayorFacturacion,
                'montoDiaMayor'             => $montoDiaMayor,
                'totalVentas'               => $totalVentas,
                'metodoMasUsado'            => $metodoMasUsado,
                'cantidadMetodoMasUsado'    => $cantidadMetodoMasUsado,
                'productoMasVendido'        => $productoMasVendido,
                'cantidadProductoMasVendido'=> $cantidadProductoMasVendido,
                'clienteMayorFacturacion'   => $clienteMayorFacturacion,
                'montoClienteMayor'         => $montoClienteMayor,
            ];

            // Datos para los gráficos
            // Evolución temporal
            $ventasPorMes = [];
            foreach ($todasLasVentas as $venta) {
                $mes = date('F', strtotime($venta['fecha']));
                $ventasPorMes[$mes] = ($ventasPorMes[$mes] ?? 0) + $venta['total_venta'];
            }
            $resultado['ventasPorMes'] = $ventasPorMes;

            // Distribución por cliente
            $resultado['clientes'] = array_keys($conteoClientes);
            $resultado['ventasPorCliente'] = array_values($conteoClientes);

            // Ventas por producto
            $resultado['productos'] = array_keys($conteoProductos);
            $resultado['ventasPorProducto'] = array_values($conteoProductos);
        }

        return $resultado;
    }

    public function mostrarVentasPorFechasAdmin(){
        $session = session();
        $queryFechaInicio = $this->request->getVar('fechaInicioQuery');
        $queryFechaFin = $this->request->getVar('fechaFinQuery'); 
        $fechaFinMasUno = date('Y-m-d', strtotime($queryFechaFin . ' +1 day'));

        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->getUsuarioAll();
        $ventaModel = new VentaCabecera_model();
        $ventaDetalleModel= new VentaDetalle_model();

        if($queryFechaInicio && $queryFechaFin && ($queryFechaInicio <= $queryFechaFin)){ 
            // Ventas paginadas
            $data['ventas'] = $ventaModel->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre")->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->where('fecha >=', $queryFechaInicio)->where('fecha <', $fechaFinMasUno)->orderBy('fecha', 'ASC')->paginate(7);

            $data['pager'] = $ventaModel->pager;

            $data['ventasPdf'] = $ventaModel->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, producto.nombre as producto_nombre, venta_detalle.cantidad, venta_detalle.precio, 
                                        (venta_detalle.cantidad * venta_detalle.precio) as subtotal")
                                ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
                                ->join('venta_detalle', 'venta_detalle.id_venta_cabecera = venta_cabecera.id_venta_cabecera')
                                ->join('producto', 'producto.id_producto = venta_detalle.id_producto')
                                ->where('fecha >=', $queryFechaInicio)
                                ->where('fecha <', $fechaFinMasUno)
                                ->orderBy('fecha', 'ASC')
                                ->findAll();

            // Resumen filtrado
            $resumen = $this->calcularResumenVentasPorFechasAdmin($ventaModel, $ventaDetalleModel, $queryFechaInicio, $queryFechaFin);
            $data = array_merge($data, $resumen);
        } else {
            $session->setFlashdata('msgFechasIncorrectasDeVentas', 'Las fechas ingresadas no han generado resultados');
            $data['ventas'] = [];
            $data['ventasPdf'] = [];
            $data['ventasPorMes'] = [];
            $data['clientes'] = [];
            $data['ventasPorCliente'] = [];
            $data['productos'] = [];
            $data['ventasPorProducto'] = [];
        }

        $session->setFlashdata('fechaInicioQueryValor', $queryFechaInicio);
        $session->setFlashdata('fechaFinQueryValor', $queryFechaFin);

        $data['titulo'] = "Dashboard | Lista de Ventas";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav');
        echo view('back/admin/listaVentas', $data);
        echo view('plantillas/footer');
    }

    private function calcularResumenVentasPorFechasAdmin($ventaModel, $ventaDetalleModel, $fechaInicio, $fechaFin){
        $fechaFinMasUno = date('Y-m-d', strtotime($fechaFin . ' +1 day'));
        // Ventas completas para el resumen (filtradas por fechas)
        $todasLasVentas = $ventaModel->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, metodo_pago.nombre as metodo_pago_nombre")->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta_cabecera.id_metodo_pago')->where('fecha >=', $fechaInicio)->where('fecha <', $fechaFinMasUno)->orderBy('fecha', 'ASC')->findAll();

        $resultado = [
            'resumen' => [
                'cantidadVentas'             => 0,
                'cantidadClientes'           => 0,
                'ventaMax'                   => 0,
                'ventaMin'                   => 0,
                'promedioFactura'            => 0,
                'clienteFrecuente'           => '',
                'diaMayorFacturacion'        => '',
                'montoDiaMayor'              => 0,
                'totalVentas'                => 0,
                'metodoMasUsado'             => '',
                'cantidadMetodoMasUsado'     => 0,
                'productoMasVendido'         => '',
                'cantidadProductoMasVendido' => 0,
                'clienteMayorFacturacion'    => '',
                'montoClienteMayor'          => 0,
            ],
            'ventasPorMes'      => [],
            'clientes'          => [],
            'ventasPorCliente'  => [],
            'productos'         => [],
            'ventasPorProducto' => [],
        ];

        if (!empty($todasLasVentas)) {
            $totales = array_column($todasLasVentas, 'total_venta');
            $clientes = array_column($todasLasVentas, 'usuario_nombre');

            $cantidadVentas = count($totales);
            $cantidadClientes = count(array_unique($clientes));
            $ventaMax = max($totales);
            $ventaMin = min($totales);
            $promedioFactura = array_sum($totales) / $cantidadVentas;
            $totalVentas = array_sum($totales);

            // Cliente más frecuente
            $conteoClientes = array_count_values($clientes);
            arsort($conteoClientes);
            $clienteFrecuente = key($conteoClientes);

            // Día con mayor facturación
            $ventasPorDia = [];
            foreach ($todasLasVentas as $venta) {
                $ventasPorDia[$venta['fecha']] = ($ventasPorDia[$venta['fecha']] ?? 0) + $venta['total_venta'];
            }
            arsort($ventasPorDia);
            $diaMayorFacturacion = key($ventasPorDia);
            $montoDiaMayor = current($ventasPorDia);

            // Método de pago más usado (con cantidad)
            $metodosPago = array_column($todasLasVentas, 'metodo_pago_nombre');
            $conteoMetodos = array_count_values($metodosPago);
            arsort($conteoMetodos);
            $metodoMasUsado = key($conteoMetodos);
            $cantidadMetodoMasUsado = current($conteoMetodos);

            // Producto más vendido (filtrado por las ventas del rango)
            $idsVentas = array_column($todasLasVentas, 'id_venta_cabecera');
            $detalles = $ventaDetalleModel->select('venta_detalle.*, producto.nombre as producto_nombre')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->whereIn('venta_detalle.id_venta_cabecera', $idsVentas)->findAll();

            $productosVendidos = array_column($detalles, 'producto_nombre');
            $conteoProductos = array_count_values($productosVendidos);
            arsort($conteoProductos);
            $productoMasVendido = key($conteoProductos);
            $cantidadProductoMasVendido = current($conteoProductos);

            // Cliente con mayor facturación
            $ventasPorCliente = [];
                foreach ($todasLasVentas as $venta) {
                    $ventasPorCliente[$venta['usuario_nombre']] = ($ventasPorCliente[$venta['usuario_nombre']] ?? 0) + $venta['total_venta'];
            }
            arsort($ventasPorCliente);
            $clienteMayorFacturacion = key($ventasPorCliente);
            $montoClienteMayor = current($ventasPorCliente);

            $resultado['resumen'] = [
                'cantidadVentas'            => $cantidadVentas,
                'cantidadClientes'          => $cantidadClientes,
                'ventaMax'                  => $ventaMax,
                'ventaMin'                  => $ventaMin,
                'promedioFactura'           => $promedioFactura,
                'clienteFrecuente'          => $clienteFrecuente,
                'diaMayorFacturacion'       => $diaMayorFacturacion,
                'montoDiaMayor'             => $montoDiaMayor,
                'totalVentas'               => $totalVentas,
                'metodoMasUsado'            => $metodoMasUsado,
                'cantidadMetodoMasUsado'    => $cantidadMetodoMasUsado,
                'productoMasVendido'        => $productoMasVendido,
                'cantidadProductoMasVendido'=> $cantidadProductoMasVendido,
                'clienteMayorFacturacion'   => $clienteMayorFacturacion,
                'montoClienteMayor'         => $montoClienteMayor,
            ];
            // Datos para los gráficos
            // Evolución temporal
            $ventasPorMes = [];
            foreach ($todasLasVentas as $venta) {
                $mes = date('F', strtotime($venta['fecha']));
                $ventasPorMes[$mes] = ($ventasPorMes[$mes] ?? 0) + $venta['total_venta'];
            }
            $resultado['ventasPorMes'] = $ventasPorMes;

            // Distribución por cliente
            $resultado['clientes'] = array_keys($conteoClientes);
            $resultado['ventasPorCliente']= array_values($conteoClientes);

            // Ventas por producto
            $resultado['productos'] = array_keys($conteoProductos);
            $resultado['ventasPorProducto']= array_values($conteoProductos);
        }

        return $resultado;
    }
}