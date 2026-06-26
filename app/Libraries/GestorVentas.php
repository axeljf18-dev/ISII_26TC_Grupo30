<?php
namespace App\Libraries;

use App\Libraries\Observador;
use App\Entities\VentaCabecera;

class GestorVentas {
    // Lista de observadores registrados
    private $observadores = [];

    // Método para agregar un observador
    public function attach(Observador $o) {
        $this->observadores[] = $o;
    }

    // Método para quitar un observador
    public function detach(Observador $o) {
        $this->observadores = array_filter($this->observadores, fn($obs) => $obs !== $o);
    }

    // Notifica a todos los observadores con la venta
    public function notify(VentaCabecera $venta) {
        foreach ($this->observadores as $obs) {
            $obs->update($venta);
        }
    }

    // Procesa la venta
    public function procesarVenta(array $productosValidos, int $idMetodoPago, float $total, int $idUsuario): void {
        $venta = new VentaCabecera($productosValidos, $idMetodoPago, $total, $idUsuario);
        $this->notify($venta);
    }
}