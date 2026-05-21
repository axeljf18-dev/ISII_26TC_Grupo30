<?php
namespace App\Models;
use CodeIgniter\Model;

class Categoria_model extends Model{
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['descripcion', 'activo'];

    public function getCategoriaAll() {
        return $this->findAll();
    }

    public function getCategoriasActivas() {
        return $this->where('activo', '1')->findAll();
    }
}