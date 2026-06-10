<?php
namespace App\Models;
use CodeIgniter\Model;

class MetodoPago_model extends Model{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id_metodo_pago';
    protected $allowedFields = ['nombre', 'descripcion', 'estado'];

    public function getMetodosPagoActivos() {
        return $this->where('estado', 'Activo')->findAll();
    }

    public function validarMetodoPago($idMetodoPago) {
        $metodo = $this->find($idMetodoPago);
        return $metodo && $metodo['estado'] === 'Activo';
    }
}