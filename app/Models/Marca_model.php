<?php
namespace App\Models;
use CodeIgniter\Model;

class Marca_model extends Model{
    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    protected $allowedFields = ['descripcion', 'activo'];

    public function getMarcasActivas() {
        return $this->where('activo', '1')->findAll();
    }

    public function validarMarca($idMarca){
        $marca = $this->where('id_marca', $idMarca)->where('activo', 1)->first();
        return $marca !== null;
    }
}