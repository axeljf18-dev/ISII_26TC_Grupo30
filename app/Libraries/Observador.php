<?php
namespace App\Libraries;

use App\Entities\VentaCabecera;

// Interfaz que deben implementar todos los observadores
interface Observador {
    // Método que se ejecuta cuando GestorVentas notifica una venta
    public function update(VentaCabecera $venta);
}