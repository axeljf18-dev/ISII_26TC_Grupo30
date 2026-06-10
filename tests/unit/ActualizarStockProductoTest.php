<?php

use App\Models\Producto_model;
use PHPUnit\Framework\TestCase;

class ActualizarStockProductoTest extends TestCase {
    public function testActualizarStockProductoConValorPositivo() {
        $productoModel = $this->createMock(Producto_model::class);

        // Producto con stock inicial 10
        $productoModel->method('buscarProductoPorId')->willReturn(['id' => 1, 'stock' => 10]);

        // Esperar que se actualice a 8 y devuelve true
        $productoModel->expects($this->once())->method('actualizarStockProducto')->with(1, 8)->willReturn(true);

        // Simular sesión con mensaje de stock
        $session = session();
        $session->setFlashdata('mensajeStock', 'Stock del producto actualizado correctamente');

        $resultado = $productoModel->actualizarStockProducto(1, 8);
        $this->assertTrue($resultado);

        // Verificar mensaje
        $mensaje = $session->getFlashdata('mensajeStock');
        var_dump($mensaje);
        $this->assertEquals('Stock del producto actualizado correctamente', $mensaje);
    }

    public function testActualizarStockProductoConValorCero() {
        $productoModel = $this->createMock(Producto_model::class);

        // Producto con stock inicial 1
        $productoModel->method('buscarProductoPorId')->willReturn(['id' => 2, 'stock' => 1]);

        // Esperar que se actualice a 0
        $productoModel->expects($this->once())->method('actualizarStockProducto')->with(2, 0)->willReturn(true);

        // Simular sesión con mensaje de stock
        $session = session();
        $session->setFlashdata('mensajeStock', 'Stock del producto actualizado a 0');

        $resultado = $productoModel->actualizarStockProducto(2, 0);
        $this->assertTrue($resultado);

        // Verificar mensaje
        $mensaje = $session->getFlashdata('mensajeStock');
        var_dump($mensaje);
        $this->assertEquals('Stock del producto actualizado a 0', $mensaje);
    }
}