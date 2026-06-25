<?php
namespace App\Models;
use CodeIgniter\Model;

class Proveedor_model extends Model{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $allowedFields = ['nombre', 'apellido', 'email'];

    // Método para obtener todos los proveedores activos
    public function getProveedoresActivos() {
        return $this->findAll();
    }

    // Método para validar si un proveedor existe
    public function validarProveedor(int $idProveedor){
        $proveedor = $this->where('id_proveedor', $idProveedor)->first();
        return $proveedor !== null;
    }
}