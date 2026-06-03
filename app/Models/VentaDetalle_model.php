<?php
namespace App\Models;
use CodeIgniter\Model;

class VentaDetalle_model extends Model{
    protected $table = 'venta_detalle';
    protected $primaryKey = 'id_venta_detalle';
    protected $allowedFields = ['id_venta_cabecera', 'id_producto', 'cantidad', 'precio'];

    public function getVentasDetalleAll() {
        return $this->findAll();
    }

    // public function getDetalles($ventaId) {
    //     return $this->where('id_venta_cabecera', $ventaId)->findAll();
    // }

    // public function getDetalles($ventaId){
    //     return $this->select('venta_detalle.*, producto.nombre, producto.descripcion, producto.precio_vta')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->where('venta_detalle.id_venta_cabecera', $ventaId)->findAll();
    // }

    public function getDetalles($ventaId){
        return $this->select('venta_detalle.*, producto.nombre, producto.descripcion')->join('producto', 'producto.id_producto = venta_detalle.id_producto')->where('venta_detalle.id_venta_cabecera', $ventaId)->findAll();
    }

}