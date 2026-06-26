<?php
namespace App\Models;
use CodeIgniter\Model;

class Direccion_model extends Model{
    protected $table = 'direccion';
    protected $primaryKey = 'id_direccion';
    protected $allowedFields = ['barrio', 'calle', 'numero', 'id_localidad', 'id_usuario'];

    // M�todo para obtener todas las direcciones activas
    public function getDireccionActivas() {
        return $this->findAll();
    }

    //  M�todo para validar si una direcci�n existe y est� activa
    public function validarDireccion(string $barrio, string $calle, int $numero){
        if(!empty($barrio) && strlen(trim($barrio)) > 100){
            return false;
        }

        if(!empty($calle) && strlen(trim($calle)) > 100){
            return false;
        }

        if(!empty($numero) && (!ctype_digit($numero) || strlen($numero) > 11)){
            return false;
        }

        return true;
    }
}