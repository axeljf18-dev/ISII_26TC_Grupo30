<?php
namespace App\Models;
use CodeIgniter\Model;

class MetodoPago_model extends Model{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id_metodo_pago';
    protected $allowedFields = ['nombre', 'descripcion', 'estado'];

    // Método para obtener todos los métodos de pago activos
    public function getMetodosPagoActivos() {
        return $this->where('estado', 'Activo')->findAll();
    }

    // Método para validar si un método de pago existe y está activo
    public function validarMetodoPago(int $idMetodoPago) {
        $metodo = $this->find($idMetodoPago);
        return $metodo && $metodo['estado'] === 'Activo';
    }
}