<?php
namespace App\Models;
use CodeIgniter\Model;

class Provincia_model extends Model{
    protected $table = 'provincia';
    protected $primaryKey = 'id_provincia';
    protected $allowedFields = ['nombre'];

    public function getProvinciasActivas(){
        return $this->select('id_provincia, nombre')->findAll();
    }

    public function validarLocalidadConProvincia($idLocalidad, $idProvincia){
        // Verificamos que la localidad esté asociada a la provincia
        $localidadModel = new Localidad_model();
        $localidad = $localidadModel->where('id_localidad', $idLocalidad)->where('id_provincia', $idProvincia)->first();

        return $localidad ? true : false;
    }
}