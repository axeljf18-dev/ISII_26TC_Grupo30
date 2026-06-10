<?php
namespace App\Services;
use App\Libraries\Observador;

class VistaCliente implements Observador {
    public function update($venta) {
        $session = session();

        if (!isset($venta['total']) || !isset($venta['metodoPago'])) {
            log_message('error', 'VistaCliente: datos de venta incompletos');
            return;
        }

        $mensaje = "¡Compra realizada con éxito! Total: {$venta['total']} con método de pago {$venta['metodoPago']}";
        $session->setFlashdata('mensajeVenta', $mensaje);

        if (isset($venta['id_venta_cabecera'])) {
            return redirect()->to(base_url('vistaDetalleCompra/' . $venta['id_venta_cabecera']));
        } else {
            return redirect()->to(base_url('misCompras'));
        }
    }
}