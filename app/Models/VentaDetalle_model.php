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

    public function getDetalles($ventaId) {
        return $this->where('id_venta_cabecera', $ventaId)->findAll();
    }
}