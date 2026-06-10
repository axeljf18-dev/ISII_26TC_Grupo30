<?php
namespace App\Models;
use CodeIgniter\Model;

class Localidad_model extends Model{
    protected $table = 'localidad';
    protected $primaryKey = 'id_localidad';
    protected $allowedFields = ['nombre', 'codigo_postal', 'id_provincia'];

    public function getLocalidadesActivas(){
        return $this->select('id_localidad, nombre, id_provincia, codigo_postal')->findAll();
    }

    public function validarLocalidad($idLocalidad, $idProvincia){
        // Primero verificamos que la localidad exista
        $localidad = $this->where('id_localidad', $idLocalidad)->first();

        if(!$localidad){
            return false; // localidad no existe
        }

        // Si existe, llamamos al modelo Provincia para validar la relación
        $provinciaModel = new Provincia_model();
        return $provinciaModel->validarLocalidadConProvincia($idLocalidad, $idProvincia);
    }
}