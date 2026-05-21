<?php
namespace App\Models;
use CodeIgniter\Model;

class VentaCabecera_model extends Model{
    protected $table = 'venta_cabecera';
    protected $primaryKey = 'id_venta_cabecera';
    protected $allowedFields = ['fecha', 'id_usuario', 'total_venta', 'id_metodo_pago'];

    public function getVentasCabeceraAll() {
        return $this->findAll();
    }

    public function getVentasCabeceraPaginadas($perPage = 7, $order = 'DESC') {
        return $this->select('venta_cabecera.*, usuario.nombre as usuario_nombre')->join('usuario', 'usuario.id_usuario = venta_cabecera.id_usuario')->orderBy('venta_cabecera.id_venta_cabecera', $order)->paginate($perPage);
    }

    public function getVentas($idUsuario) {
        return $this->where('id_usuario', $idUsuario)->findAll();
    }
}