<?php
namespace App\Services;
use App\Libraries\Observador;
use App\Models\Usuarios_model;
use App\Models\VentaCabecera_model;
use App\Models\VentaDetalle_model;

class Facturacion implements Observador {
    public function update($venta) {
        // Validar que exista la cabecera
        if (!isset($venta['id_venta_cabecera'])) {
            log_message('error', 'Facturación: venta sin cabecera');
            return;
        }

        // Mostrar la vista de detalle de venta como "factura"
        // Podés reutilizar tu método mostrarDetalleVenta($idVenta)
        return redirect()->to(base_url('vistaDetalleCompra/' . $venta['id_venta_cabecera']));
    }
}