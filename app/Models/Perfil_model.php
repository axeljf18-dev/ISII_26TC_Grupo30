<?php
namespace App\Models;
use CodeIgniter\Model;

class Perfil_model extends Model{
    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = ['descripcion', 'baja'];

    public function getPerfilAll() {
        return $this->findAll();
    }

    public function getPerfilActivos() {
        return $this->where('baja', 'NO')->findAll();
    }
}