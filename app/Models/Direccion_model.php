<?php
namespace App\Models;
use CodeIgniter\Model;

class Direccion_model extends Model{
    protected $table = 'direccion';
    protected $primaryKey = 'id_direccion';
    protected $allowedFields = ['barrio', 'calle', 'numero', 'id_localidad', 'id_usuario'];

    public function getDireccionAll() {
        return $this->findAll();
    }
}