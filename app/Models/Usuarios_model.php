<?php
namespace App\Models;
use CodeIgniter\Model;

class Usuarios_model extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'usuario', 'pass', 'id_perfil', 'baja'];

    public function getUsuarioAll() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->findAll();
    }

    public function getUsuariosPaginados($perPage = 7) {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')->join('perfil', 'perfil.id_perfil = usuario.id_perfil')->where('usuario.baja', 'NO')->paginate($perPage);
    }

    public function getUsuariosDesactivadosPaginados($perPage = 7) {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')->join('perfil', 'perfil.id_perfil = usuario.id_perfil')->where('usuario.baja', 'SI')->paginate($perPage);
    }

    public function buscarUsuariosActivosPaginados($query, $perPage = 7) {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->like('usuario.nombre', $query)
                    ->where('usuario.baja', 'NO')
                    ->paginate($perPage);
    }

    public function buscarUsuariosDesactivadosPaginados($query, $perPage = 7) {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->like('usuario.nombre', $query)
                    ->where('usuario.baja', 'SI')
                    ->paginate($perPage);
    }
}