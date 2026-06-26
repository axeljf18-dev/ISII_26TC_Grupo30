<?php
namespace App\Services;
use App\Libraries\Observador;
use App\Entities\VentaCabecera;

class VistaCliente implements Observador {
    // Observador de VistaCliente: muestra mensaje de confirmación y redirige al detalle de compra
    public function update(VentaCabecera $venta) {
        $session = session();

        if ($venta->getTotal() <= 0 || $venta->getMetodoPago() === null) {
            log_message('error', 'VistaCliente: datos de venta incompletos');
            return;
        }

        $mensaje = "¡Compra realizada con éxito! Total: {$venta->getTotal()} con método de pago {$venta->getMetodoPago()}";
        $session->setFlashdata('mensajeVenta', $mensaje);

        if ($venta->getId() !== null) {
            return redirect()->to(base_url('vistaDetalleCompra/' . $venta->getId()));
        } else {
            return redirect()->to(base_url('misCompras'));
        }
    }
}