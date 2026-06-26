<?php

use App\Controllers\VentaCabecera_controller;
use App\Models\MetodoPago_model;
use App\Models\Producto_model;
use PHPUnit\Framework\TestCase;

class ValidarVentaTest extends TestCase {
    public function testValidarVentaMetodoPagoInvalido() {
        // Instancia del controlador a probar
        $ventaController = new VentaCabecera_controller();

        // Mock del modelo MetodoPago_model
        $metodoPagoModel = $this->createMock(MetodoPago_model::class);
        $metodoPagoModel->method('validarMetodoPago')->willReturn(false);

        // Inyectar el mock en el controlador
        $ventaController->metodoPagoModel = $metodoPagoModel;

        // Carrito con productos
        $carritoItems = [
            ['id' => 1, 'qty' => 2, 'subtotal' => 200, 'name' => 'Producto A', 'rowid' => 'abc']
        ];

        // Ejecutar el método con método de pago inválido (Ejemplo id = 0)
        $resultado = $ventaController->validarVenta(0, $carritoItems);

        // Verificar que el resultado es un RedirectResponse
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $resultado);

        // Verificar que la redirección apunta a /carrito
        $this->assertStringContainsString('/carrito', $resultado->getHeaderLine('Location'));

        // Verificar que el mensaje de sesión sea el esperado
        $session = session();
        $this->assertEquals('Debe seleccionar un método de pago válido', $session->getFlashdata('mensaje'));
    }

    public function testValidarVentaProductoSinStock() {
        // Instancia del controlador a usar
        $ventaController = new VentaCabecera_controller();

        // Mock del modelo MetodoPago_model (método válido)
        $metodoPagoModel = $this->createMock(MetodoPago_model::class);
        $metodoPagoModel->method('validarMetodoPago')->willReturn(true);
        $ventaController->metodoPagoModel = $metodoPagoModel;

        // Mock del modelo Producto_model (sin stock)
        $productoModel = $this->createMock(Producto_model::class);
        $productoModel->method('validarStock')->willReturn(false);
        $ventaController->productoModel = $productoModel;

        // Carrito con un producto
        $carritoItems = [
            ['id' => 1, 'qty' => 5, 'subtotal' => 500, 'name' => 'Producto A', 'rowid' => 'abc']
        ];

        // Ejecutar método
        $resultado = $ventaController->validarVenta(1, $carritoItems);

        // Verificar que el resultado es un RedirectResponse
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $resultado);

        // Verificar que la redirección apunta a /carrito
        $this->assertStringContainsString('/carrito', $resultado->getHeaderLine('Location'));

        // Verificar que el mensaje de sesión es exactamente el esperado
        $session = session();
        $mensaje = $session->getFlashdata('mensaje');

        // Mostrar mensaje
        var_dump($mensaje); 

        // Aserción
        $this->assertEquals('Los siguientes productos: "<b>' . $carritoItems[0]['name'] . '</b>". No tienen stock suficiente y fueron eliminados de "Mi Carrito"', $mensaje);
    }

    public function testValidarVentaTodosProductosSinStock() {
        // Instancia del controlador a usar
        $ventaController = new VentaCabecera_controller();

        // Mock del modelo MetodoPago_model (método válido)
        $metodoPagoModel = $this->createMock(MetodoPago_model::class);
        $metodoPagoModel->method('validarMetodoPago')->willReturn(true);
        $ventaController->metodoPagoModel = $metodoPagoModel;

        // Mock del modelo Producto_model (todos sin stock)
        $productoModel = $this->createMock(Producto_model::class);
        $productoModel->method('validarStock')->willReturn(false);
        $ventaController->productoModel = $productoModel;

        // Carrito con varios productos
        $carritoItems = [
            ['id' => 1, 'qty' => 2, 'subtotal' => 200, 'name' => 'Producto A', 'rowid' => 'abc'],
            ['id' => 2, 'qty' => 1, 'subtotal' => 100, 'name' => 'Producto B', 'rowid' => 'def']
        ];

        // Ejecutar método
        $resultado = $ventaController->validarVenta(1, $carritoItems);

        // Verificar que el resultado es un RedirectResponse
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $resultado);

        // Verificar que la redirección apunta a /carrito
        $this->assertStringContainsString('/carrito', $resultado->getHeaderLine('Location'));

        // Verificar que el mensaje de sesión indica que no hay productos válidos
        $session = session();
        $mensaje = $session->getFlashdata('mensaje');

        // Mostrar el mensaje
        var_dump($mensaje); 

        // Extraer solo los nombres de los productos
        $nombresProductos = array_column($carritoItems, 'name');

        // Unirlos
        $listaNombres = implode(', ', $nombresProductos);

        // Mensaje
        $mensajeEsperado = 'Los siguientes productos: "<b>' . $listaNombres . '</b>". No tienen stock suficiente y fueron eliminados de "Mi Carrito"';

        // Aserción
        $this->assertEquals($mensajeEsperado, $mensaje);
    }

    public function testValidarVentaProductosMixtos() {
        // Instancia del controlador a usar
        $ventaController = new VentaCabecera_controller();

        // Mock del modelo MetodoPago_model (método válido)
        $metodoPagoModel = $this->createMock(MetodoPago_model::class);
        $metodoPagoModel->method('validarMetodoPago')->willReturn(true);
        $ventaController->metodoPagoModel = $metodoPagoModel;

        // Mock del modelo Producto_model
        $productoModel = $this->createMock(Producto_model::class);
        $productoModel->method('validarStock')->willReturnMap([
            [1, 2, false], // Producto A sin stock
            [2, 1, true],  // Producto B con stock
        ]);
        $ventaController->productoModel = $productoModel;

        // Carrito con dos productos
        $carritoItems = [
            ['id' => 1, 'qty' => 2, 'subtotal' => 200, 'name' => 'Producto A', 'rowid' => 'abc'],
            ['id' => 2, 'qty' => 1, 'subtotal' => 100, 'name' => 'Producto B', 'rowid' => 'def']
        ];

        // Ejecutar método
        $resultado = $ventaController->validarVenta(1, $carritoItems);

        // Verificar que el resultado es un RedirectResponse
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $resultado);

        // Verificar que la redirección apunta a /carrito
        $this->assertStringContainsString('/carrito', $resultado->getHeaderLine('Location'));

        // Verificar que el mensaje de sesión indica los productos eliminados
        $session = session();
        $mensaje = $session->getFlashdata('mensaje');

        // Mostrar el mensaje 
        var_dump($mensaje);

        // Extraer solo los nombres de los productos eliminados
        $productosEliminados = ['Producto A'];
        $listaNombres = implode(', ', $productosEliminados);

        // Mensaje
        $mensajeEsperado = 'Los siguientes productos: "<b>' . $listaNombres . '</b>". No tienen stock suficiente y fueron eliminados de "Mi Carrito"';
        // Aserción
        $this->assertEquals($mensajeEsperado, $mensaje);
    }

    public function testValidarVentaTodosProductosValidos() {
        // Mock parcial del controlador
        $ventaController = $this->getMockBuilder(VentaCabecera_controller::class)->onlyMethods(['registrarVenta'])->getMock();

        // Mock del modelo MetodoPago_model (método válido)
        $metodoPagoModel = $this->createMock(MetodoPago_model::class);
        $metodoPagoModel->method('validarMetodoPago')->willReturn(true);
        $ventaController->metodoPagoModel = $metodoPagoModel;

        // Mock del modelo Producto_model (todos con stock)
        $productoModel = $this->createMock(Producto_model::class);
        $productoModel->method('validarStock')->willReturn(true);
        $ventaController->productoModel = $productoModel;

        // Simular registrarVenta para evitar acceso a la base de datos
        $ventaController->method('registrarVenta')->willReturn(redirect()->to('/detalleCompra')->with('mensaje', '¡Compra realizada con éxito!'));

        // Carrito con varios productos válidos
        $carritoItems = [
            ['id' => 1, 'qty' => 2, 'subtotal' => 200, 'name' => 'Producto A', 'rowid' => 'abc'],
            ['id' => 2, 'qty' => 1, 'subtotal' => 100, 'name' => 'Producto B', 'rowid' => 'def']
        ];

        // Ejecutar método
        $resultado = $ventaController->validarVenta(1, $carritoItems);

        // Verificar redirección
        $this->assertInstanceOf(\CodeIgniter\HTTP\RedirectResponse::class, $resultado);
        $this->assertStringContainsString('/detalleCompra', $resultado->getHeaderLine('Location'));

        // Verificar mensaje 
        $session = session();
        $mensaje = $session->getFlashdata('mensaje');

        // Mostrar el mensaje 
        var_dump($mensaje);

        $this->assertEquals('¡Compra realizada con éxito!', $mensaje);
    }
}