<?php
namespace App\Services;
use App\Libraries\Observador;
use App\Models\Producto_model;

class Inventario implements Observador {
    public function update($venta) {
        if (!isset($venta['productos']) || !is_array($venta['productos'])) {
            log_message('error', 'Inventario: datos de venta inválidos');
            return;
        }

        $productoModel = new Producto_model();

        // Recorremos los productos de la venta
        foreach ($venta['productos'] as $item) {
            // Buscar producto actual
            $producto = $productoModel->buscarProductoPorId($item['id']);

            if ($producto && $producto['stock'] >= $item['qty']) {
                // Descontar stock
                $nuevoStock = $producto['stock'] - $item['qty'];
                $productoModel->actualizarStockProducto($item['id'], $nuevoStock);
            } else {
                // Manejo de error: stock insuficiente
                log_message('error', "Inventario: Stock insuficiente para producto ID {$item['id']}");
            }
        }
    }
}