<?php
use PHPUnit\Framework\TestCase;
use App\Libraries\GestorVentas;
use App\Services\Inventario;

class ObserverTest extends TestCase {
    public function testInventarioObserver() {
        $gestor = new GestorVentas();
        $inventario = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update($venta) { $this->ejecutado = true; }
        };
        $gestor->attach($inventario);
        $venta = [
            'productos' => [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            'metodoPago' => 1,
            'total' => 200,
            'id_usuario' => 5
        ];
        $gestor->notify($venta);

        $this->assertTrue($inventario->ejecutado);
    }

    public function testFacturacionObserver() {
        $gestor = new GestorVentas();
        $facturacion = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update($venta) { $this->ejecutado = true; }
        };
        $gestor->attach($facturacion);
        $venta = [
            'productos' => [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            'metodoPago' => 1,
            'total' => 200,
            'id_usuario' => 5
        ];
        $gestor->notify($venta);
        $this->assertTrue($facturacion->ejecutado);
    }

    public function testVistaClienteObserver() {
        $gestor = new GestorVentas();
        $vistaCliente = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update($venta) { $this->ejecutado = true; }
        };
        $gestor->attach($vistaCliente);
        $venta = [
            'productos' => [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            'metodoPago' => 1,
            'total' => 200,
            'id_usuario' => 5
        ];
        $gestor->notify($venta);
        $this->assertTrue($vistaCliente->ejecutado);
    }
}