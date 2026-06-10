<?php
namespace App\Models;
use CodeIgniter\Model;

class VentaDetalle_model extends Model{
    protected $table = 'venta_detalle';
    protected $primaryKey = 'id_venta_detalle';
    protected $allowedFields = ['id_venta_cabecera', 'id_producto', 'cantidad', 'precio'];

    public function getBuscarDetalles($idVenta){
        return $this->select('venta_detalle.*, producto.nombre, producto.descripcion')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->where('venta_detalle.id_venta_cabecera', $idVenta)->findAll();
    }

    public function registrarDetalleVenta($idVenta, $item) {
        $detalle = [
            'id_venta_cabecera' => $idVenta,
            'id_producto' => $item['id'],
            'cantidad' => $item['qty'],
            'precio' => $item['price']
        ];
        return $this->insert($detalle);
    }
}