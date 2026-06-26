<?php
namespace App\Models;
use CodeIgniter\Model;

class Marca_model extends Model{
    protected $table = 'marca';
    protected $primaryKey = 'id_marca';
    protected $allowedFields = ['descripcion', 'activo'];

    // Método para obtener todas las marcas activas
    public function getMarcasActivas() {
        return $this->where('activo', '1')->findAll();
    }

    // Método para validar si una marca existe y está activa
    public function validarMarca(int $idMarca){
        $marca = $this->where('id_marca', $idMarca)->where('activo', 1)->first();
        return $marca !== null;
    }
}