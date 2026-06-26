<?php
namespace App\Models;
use CodeIgniter\Model;

class Perfil_model extends Model{
    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    protected $allowedFields = ['descripcion', 'baja'];

    //  Método para obtener todos los perfiles activos
    public function getPerfilesActivos() {
        return $this->where('baja', 'NO')->findAll();
    }

    // Método para validar si un perfil existe y no está dado de baja
    public function validarPerfil(int $idPerfil){
        $perfil = $this->where('id_perfil', $idPerfil)->where('baja', 'NO')->first();
        return $perfil ? true : false;
    }
}