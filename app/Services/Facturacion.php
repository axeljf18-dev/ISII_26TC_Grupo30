<?php
namespace App\Services;
use App\Libraries\Observador;
use App\Models\Usuarios_model;
use App\Models\VentaCabecera_model;
use App\Models\VentaDetalle_model;
use App\Entities\VentaCabecera;

class Facturacion implements Observador {
    // Observador de Facturación: valida la cabecera y redirige a la vista de factura
    public function update(VentaCabecera $venta) {
        // Validar que exista la cabecera
        if ($venta->getId() === null) {
            log_message('error', 'Facturación: venta sin cabecera');
            return;
        }

        // Mostrar la vista de detalle de venta como "factura"
        return redirect()->to(base_url('vistaDetalleCompra/' . $venta->getId()));
    }
}