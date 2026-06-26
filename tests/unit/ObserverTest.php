<?php
use PHPUnit\Framework\TestCase;
use App\Libraries\GestorVentas;
use App\Services\Inventario;
use App\Entities\VentaCabecera;

class ObserverTest extends TestCase {
    // Testea que el observador Inventario se ejecute al notificar una venta
    public function testInventarioObserver() {
        $gestor = new GestorVentas();
        $inventario = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update(VentaCabecera $venta) { $this->ejecutado = true; }
        };
        $gestor->attach($inventario);
        $venta = new VentaCabecera(
            [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            1, 200,5
        );
        $gestor->notify($venta);
        $this->assertTrue($inventario->ejecutado);
    }

    // Testea que el observador Facturación se ejecute al notificar una venta
    public function testFacturacionObserver() {
        $gestor = new GestorVentas();
        $facturacion = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update(VentaCabecera $venta) { $this->ejecutado = true; }
        };
        $gestor->attach($facturacion);
        $venta = new VentaCabecera(
            [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            1, 200, 5
        );
        $gestor->notify($venta);
        $this->assertTrue($facturacion->ejecutado);
    }

    // Testea que el observador VistaCliente se ejecute al notificar una venta
    public function testVistaClienteObserver() {
        $gestor = new GestorVentas();
        $vistaCliente = new class implements \App\Libraries\Observador {
            public bool $ejecutado = false;
            public function update(VentaCabecera $venta) { $this->ejecutado = true; }
        };
        $gestor->attach($vistaCliente);
        $venta = new VentaCabecera(
            [['id' => 1, 'qty' => 2, 'price' => 100, 'subtotal' => 200]],
            1, 200, 5
        );
        $gestor->notify($venta);
        $this->assertTrue($vistaCliente->ejecutado);
    }
}