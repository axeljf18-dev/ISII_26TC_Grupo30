<?php
namespace App\Services;
use App\Libraries\Observador;
use App\Models\Producto_model;
use App\Entities\VentaCabecera;

class Inventario implements Observador {
    // Observador de Inventario: descuenta stock de productos vendidos
    public function update(VentaCabecera $venta) {
        $productos = $venta->getProductos();
        if (empty($productos)) {
            log_message('error', 'Inventario: datos de venta inválidos');
            return;
        }

        $productoModel = new Producto_model();

        // Recorremos los productos de la venta
        foreach ($productos as $item) {
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