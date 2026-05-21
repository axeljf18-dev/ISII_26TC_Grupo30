<?php
namespace App\Models;
use CodeIgniter\Model;

class Localidad_model extends Model{
    protected $table = 'localidad';
    protected $primaryKey = 'id_localidad';
    protected $allowedFields = ['nombre', 'codigo_postal', 'id_provincia'];

    public function getLocalidadAll() {
        return $this->findAll();
    }

    public function getLocalidadConProvincia(){
        return $this->select('localidad.id_localidad, localidad.nombre as localidad_nombre, localidad.codigo_postal, provincia.nombre as provincia_nombre')->join('provincia', 'provincia.id_provincia = localidad.id_provincia')->findAll();
    }
}