<?php
namespace App\Models;
use CodeIgniter\Model;

class Perfil_model extends Model{
    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = ['descripcion', 'baja'];

    public function getPerfilesActivos() {
        return $this->where('baja', 'NO')->findAll();
    }

    public function validarPerfil($idPerfil){
        $perfil = $this->where('id_perfil', $idPerfil)->where('baja', 'NO')->first();
        return $perfil ? true : false;
    }
}