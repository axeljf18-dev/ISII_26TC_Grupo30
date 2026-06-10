<?php
namespace App\Libraries;

use App\Libraries\Observador;

class GestorVentas {
    private $observadores = [];

    public function attach(Observador $o) {
        $this->observadores[] = $o;
    }

    public function detach(Observador $o) {
        $this->observadores = array_filter($this->observadores, fn($obs) => $obs !== $o);
    }

    public function notify($venta) {
        foreach ($this->observadores as $obs) {
            $obs->update($venta);
        }
    }

    public function procesarVenta($productos, $metodoPago, $total) {
        // lógica para registrar venta en BD
        $venta = [
            'productos' => $productos,
            'metodoPago' => $metodoPago,
            'total' => $total
        ];
        $this->notify($venta);
    }
}