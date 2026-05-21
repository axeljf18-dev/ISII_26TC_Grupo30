<?php
namespace App\Models;
use CodeIgniter\Model;

class Provincia_model extends Model{
    protected $table = 'provincia';
    protected $primaryKey = 'id_provincia';
    protected $allowedFields = ['nombre'];

    public function getProvinciaAll() {
        return $this->findAll();
    }
}