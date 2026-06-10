<?php
namespace App\Models;
use CodeIgniter\Model;

class Proveedor_model extends Model{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $allowedFields = ['nombre', 'apellido', 'email'];

    public function getProveedoresActivos() {
        return $this->findAll();
    }

    public function validarProveedor($idProveedor){
        $proveedor = $this->where('id_proveedor', $idProveedor)->first();
        return $proveedor !== null;
    }
}