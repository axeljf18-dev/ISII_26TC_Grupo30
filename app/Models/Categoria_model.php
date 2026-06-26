<?php
namespace App\Models;
use CodeIgniter\Model;

class Categoria_model extends Model{
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields = ['descripcion', 'activo'];

    // Método para obtener todas las categorías activas
    public function getCategoriasActivas() {
        return $this->where('activo', '1')->findAll();
    }
    
    // Método para validar si una categoría existe y está activa
    public function validarCategoria(int $idCategoria){
        $categoria = $this->where('id_categoria', $idCategoria)->where('activo', 1)->first();
        return $categoria !== null;
    }
}