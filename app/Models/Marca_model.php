<?php
namespace App\Models;
use CodeIgniter\Model;

class Marca_model extends Model{
    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    protected $allowedFields = ['descripcion', 'activo'];

    public function getMarcaAll() {
        return $this->findAll();
    }

    public function getMarcasActivas() {
        return $this->where('activo', '1')->findAll();
    }

    public function validarMarca($id_marca){
        $marca = $this->where('id_marca', $id_marca)->where('activo', 1)->first();
        return $marca !== null;
    }
}