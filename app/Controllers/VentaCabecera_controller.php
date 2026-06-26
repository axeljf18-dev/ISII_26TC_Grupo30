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
use App\Models\MetodoPago_model;
// use App\Services\CarritoService;
use DateTime as Date; 
use App\Models\VentaCabecera_model as VentaCabecera;
use App\Models\VentaDetalle_model as VentaDetalle;

class VentaCabecera_controller extends Controller{
    public $productoModel;
    public $metodoPagoModel;
    public $carritoContents = [];

    public function __construct()
    {
        $this->metodoPagoModel = new MetodoPago_model();
        $this->productoModel = new Producto_model();
    }

    // Metodo para recibir los datos de la venta desde el formulario
    public function recibirDatosDeLaVenta() {
        $request = \Config\Services::request();

        // Capturar datos del formulario
        $idMetodoPago = (int) $request->getPost('id_metodo_pago');

        // Obtener carrito
        $cartController = new Carrito_controller();
        $carritoItems = $cartController->devolverCarrito();

        // Pasar los datos a validarVenta
        return $this->validarVenta($idMetodoPago, $carritoItems);
    }

    // Validar venta (método de pago y stock de productos)
    public function validarVenta(int $idMetodoPago, array $carritoItems){
        $session = session();

        $metodoPagoModel = new MetodoPago_model();
        $productoModel = new Producto_model();
        $productosValidos = [];
        $productosSinStock = [];
        $total = 0;

        // Validar método de pago
        if (!$this->metodoPagoModel->validarMetodoPago($idMetodoPago)) {
            $session->setFlashdata('mensaje', 'Debe seleccionar un método de pago válido');
            return redirect()->to('/carrito');
        }

        // Validar stock
        foreach ($carritoItems as $item) {
            if ($this->productoModel->validarStock($item['id'], $item['qty'])) {
                $productosValidos[] = $item;
                $total += $item['subtotal'];
            } else {
                $productosSinStock[] = $item['name'];
                $cartController = new Carrito_controller();
                $cartController->eliminarProducto($item['rowid']);
            }
        }

        // Manejo de errores
        if (!empty($productosSinStock)) {
            $listaNombres = implode(', ', $productosSinStock);
            $mensaje = 'Los siguientes productos: "<b>' . $listaNombres . '</b>". No tienen stock suficiente y fueron eliminados de "Mi Carrito"';
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

    // Registrar venta (cabecera y detalle)
    public function registrarVenta(array $productosValidos, int $idMetodoPago, float $total){
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
        $idVenta = $ventasModel->insert($nuevaVenta);

        // Registrar detalle y actualizar stock
        foreach ($productosValidos as $item) {
            $detalleModel->registrarDetalleVenta($idVenta, $item);

            $producto = $productoModel->buscarProductoPorId($item['id']);
            $productoModel->actualizarStockProducto($item['id'], $producto['stock'] - $item['qty']);
        }

        // Vaciar carrito y confirmar
        $cartController = new Carrito_controller();
        $cartController->eliminarCarrito();

        $session->setFlashdata('mensajeVenta', '¡Compra realizada con éxito!');
        return redirect()->to(base_url('vistaDetalleCompra/' . $idVenta));
    }

    // Mostrar compras del cliente
    public function mostrarMisComprasCliente(){ 
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

        $userId = session()->get('id_usuario');
        $ventasCabeceraModel = new VentaCabecera_model();
        $data['ventas'] = $ventasCabeceraModel->select('venta_cabecera.*, usuario.apellido, usuario.nombre')->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->where('venta_cabecera.id_usuario', $userId)->orderBy('fecha', 'ASC')->paginate(7);

        $data['pager'] = $ventasCabeceraModel->pager;

        $data['titulo'] = "NetShop | Mis Compras";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/misCompras', $data);
        echo view('plantillas/footer', $data);
    }

    // Mostrar compras del cliente filtradas por fechas
    public function mostrarComprasPorFechasCliente(){
        $session = session();
        $queryFechaInicioStr = $this->request->getVar('fechaInicioQuery20');
        $queryFechaFinStr = $this->request->getVar('fechaFinQuery20'); 

        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

        $queryFechaInicio = $queryFechaInicioStr ? new \DateTime($queryFechaInicioStr) : null;
        $queryFechaFin = $queryFechaFinStr ? new \DateTime($queryFechaFinStr) : null;

        $resultadoBusqueda = $this->filtrarComprasCliente($queryFechaInicio, $queryFechaFin);
        $data = array_merge($data, $resultadoBusqueda);

        $data['titulo'] = "NetShop | Mis Compras";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/misCompras', $data);
        echo view('plantillas/footer', $data);
    }

    // Metodo para filtrar compras del cliente por fechas
    private function filtrarComprasCliente(?Date $queryFechaInicio, ?Date $queryFechaFin){
        $session = session();
        $userId = session()->get('id_usuario');
        $ventaModel = new VentaCabecera_model();

        $data = [];

        if($queryFechaInicio && $queryFechaFin && ($queryFechaInicio <= $queryFechaFin)){ 
            $fechaFinMasUno = clone $queryFechaFin;
            $fechaFinMasUno->modify('+1 day');

            $data['ventas'] = $ventaModel
                ->select('venta_cabecera.*, usuario.apellido, usuario.nombre')
                ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
                ->where('fecha >=', $queryFechaInicio->format('Y-m-d'))
                ->where('fecha <', $fechaFinMasUno->format('Y-m-d'))
                ->where('venta_cabecera.id_usuario', $userId)
                ->orderBy('fecha', 'ASC')
                ->paginate(7);

            $data['pager'] = $ventaModel->pager;
        } else {
            $session->setFlashdata('msgFechasIncorrectas', 'Las fechas ingresadas no han generado resultados');
            $data['ventas'] = [];
        }

        $session->setFlashdata('fechaInicioQueryValor20', $queryFechaInicio?->format('Y-m-d'));
        $session->setFlashdata('fechaFinQueryValor20', $queryFechaFin?->format('Y-m-d'));

        return $data;
    }

    // Mostrar todas las ventas para el administrador
    public function mostrarVentasAdmin(){
        $ventasCabeceraModel = new VentaCabecera_model();
        $ventaDetalleModel = new VentaDetalle_model();
        $data['ventas'] = $ventasCabeceraModel->getVentasCabeceraAll('DESC');
        $data['pager'] = $ventasCabeceraModel->pager;

        // Para el PDF (todas las ventas)
        $data['ventasPdf'] = $ventasCabeceraModel
            ->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, producto.nombre as producto_nombre, venta_detalle.cantidad, venta_detalle.precio, (venta_detalle.cantidad * venta_detalle.precio) as subtotal")
            ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
            ->join('venta_detalle', 'venta_detalle.id_venta_cabecera = venta_cabecera.id_venta_cabecera')
            ->join('producto', 'producto.id_producto = venta_detalle.id_producto')
            ->orderBy('fecha', 'ASC')
            ->findAll();

        $resumen = $this->calcularResumenVentasAdmin($ventasCabeceraModel, $ventaDetalleModel);
        $data = array_merge($data, $resumen);

        $data['titulo'] = "Dashboard | Lista de Ventas";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav');
        echo view('back/admin/listaVentas', $data);
        echo view('plantillas/footer');
    }

    // Calcular resumen de ventas para el administrador
    private function calcularResumenVentasAdmin(VentaCabecera $ventasCabecera, VentaDetalle $ventaDetalle){
        // Para el resumen (todas las ventas)
        $todasLasVentas = $ventasCabecera->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, metodo_pago.nombre as metodo_pago_nombre")->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta_cabecera.id_metodo_pago')->orderBy('fecha', 'ASC')->findAll();

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
            $detalles = $ventaDetalle->select('venta_detalle.*, producto.nombre as producto_nombre')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->findAll();
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

    // Mostrar ventas filtradas por fechas para el administrador
    public function mostrarVentasPorFechasAdmin(){
        $session = session();
        $queryFechaInicioStr = $this->request->getVar('fechaInicioQuery');
        $queryFechaFinStr = $this->request->getVar('fechaFinQuery'); 

        $ventaModel = new VentaCabecera_model();
        $ventaDetalleModel= new VentaDetalle_model();

        $queryFechaInicio = $queryFechaInicioStr ? new Date($queryFechaInicioStr) : null;
        $queryFechaFin = $queryFechaFinStr ? new Date($queryFechaFinStr) : null;

        if($queryFechaInicio && $queryFechaFin && ($queryFechaInicio <= $queryFechaFin)){ 
            $fechaFinMasUno = clone $queryFechaFin;
            $fechaFinMasUno->modify('+1 day');

            // Ventas paginadas
            $data['ventas'] = $ventaModel
                ->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre")
                ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
                ->where('fecha >=', $queryFechaInicio->format('Y-m-d'))
                ->where('fecha <', $fechaFinMasUno->format('Y-m-d'))
                ->orderBy('fecha', 'ASC')
                ->paginate(7);

            $data['pager'] = $ventaModel->pager;

            $data['ventasPdf'] = $ventaModel
                ->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, producto.nombre as producto_nombre, venta_detalle.cantidad, venta_detalle.precio, (venta_detalle.cantidad * venta_detalle.precio) as subtotal")
                ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
                ->join('venta_detalle', 'venta_detalle.id_venta_cabecera = venta_cabecera.id_venta_cabecera')
                ->join('producto', 'producto.id_producto = venta_detalle.id_producto')
                ->where('fecha >=', $queryFechaInicio->format('Y-m-d'))
                ->where('fecha <', $fechaFinMasUno->format('Y-m-d'))
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

        $session->setFlashdata('fechaInicioQueryValor', $queryFechaInicio?->format('Y-m-d'));
        $session->setFlashdata('fechaFinQueryValor', $queryFechaFin?->format('Y-m-d'));

        $data['titulo'] = "Dashboard | Lista de Ventas";
        echo view('plantillas/header', $data);
        echo view('plantillas/nav');
        echo view('back/admin/listaVentas', $data);
        echo view('plantillas/footer');
    }

    // Calcular resumen de ventas filtradas por fechas para el administrador
    private function calcularResumenVentasPorFechasAdmin(VentaCabecera $ventaCabecera, VentaDetalle $ventaDetalle, ?Date $queryFechaInicio, ?Date $queryFechaFin){
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

        if ($queryFechaInicio && $queryFechaFin) {
            $fechaFinMasUno = clone $queryFechaFin;
            $fechaFinMasUno->modify('+1 day');

            // Ventas completas para el resumen (filtradas por fechas)
            $todasLasVentas = $ventaCabecera
                ->select("venta_cabecera.*, CONCAT(usuario.apellido, ', ', usuario.nombre) as usuario_nombre, metodo_pago.nombre as metodo_pago_nombre")
                ->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')
                ->join('metodo_pago', 'metodo_pago.id_metodo_pago = venta_cabecera.id_metodo_pago')
                ->where('fecha >=', $queryFechaInicio->format('Y-m-d'))
                ->where('fecha <', $fechaFinMasUno->format('Y-m-d'))
                ->orderBy('fecha', 'ASC')
                ->findAll();

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
                $detalles = $ventaDetalle->select('venta_detalle.*, producto.nombre as producto_nombre')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->whereIn('venta_detalle.id_venta_cabecera', $idsVentas)->findAll();
    
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
        }

        return $resultado;
    }
}