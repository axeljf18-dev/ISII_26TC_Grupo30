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
                    ->orderBy('usuario.id_usuario', 'DESC')
                    ->paginate(7);
    }

    public function getUsuariosActivos() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->where('usuario.baja', 'NO')
                    ->paginate(7);
    }

    public function getUsuariosDesactivados() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->where('usuario.baja', 'SI')
                    ->paginate(7);
    }

    public function buscarUsuariosAll($query) {
        if($query){
            return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                        ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                        ->like('usuario.nombre', $query)
                        ->paginate(7);
        }
        return [];
    }

    public function buscarUsuariosActivos($query) {
        if($query){
            return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                        ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                        ->like('usuario.nombre', $query)
                        ->where('usuario.baja', 'NO')
                        ->paginate(7);
        }
        return [];
    }

    public function buscarUsuariosDesactivados($query) {
        if($query){
            return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                        ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                        ->like('usuario.nombre', $query)
                        ->where('usuario.baja', 'SI')
                        ->paginate(7);
        }
        return [];
    }
}