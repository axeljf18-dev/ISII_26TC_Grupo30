<?php
namespace App\Models;
use CodeIgniter\Model;

class Proveedor_model extends Model{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $allowedFields = ['nombre', 'apellido', 'email'];

    public function getProveedorAll() {
        return $this->findAll();
    }
}