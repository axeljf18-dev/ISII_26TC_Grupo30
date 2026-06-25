<?php
namespace App\Models;
use CodeIgniter\Model;

class Provincia_model extends Model{
    protected $table = 'provincia';
    protected $primaryKey = 'id_provincia';
    protected $allowedFields = ['nombre'];

    // Método para obtener todas las provincias activas
    public function getProvinciasActivas(){
        return $this->select('id_provincia, nombre')->findAll();
    }

    // Método para validar si una localidad pertenece a una provincia específica
    public function validarLocalidadConProvincia(int $idLocalidad, int $idProvincia){
        // Verificamos que la localidad esté asociada a la provincia
        $localidadModel = new Localidad_model();
        $localidad = $localidadModel->where('id_localidad', $idLocalidad)->where('id_provincia', $idProvincia)->first();

        return $localidad ? true : false;
    }
}