<?php
namespace App\Models;
use CodeIgniter\Model;

class Usuarios_model extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'usuario', 'pass', 'id_perfil', 'baja'];

    // Método para obtener todos los usuarios con su perfil
    public function getUsuarioAll() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->orderBy('usuario.id_usuario', 'DESC')
                    ->paginate(7);
    }

    // Método para obtener todos los usuarios activos con su perfil
    public function getUsuariosActivos() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->where('usuario.baja', 'NO')
                    ->paginate(7);
    }

    // Método para obtener todos los usuarios desactivados con su perfil
    public function getUsuariosDesactivados() {
        return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                    ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                    ->where('usuario.baja', 'SI')
                    ->paginate(7);
    }

    // Método para buscar usuarios por nombre
    public function buscarUsuariosAll(string $query) {
        if($query){
            return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                        ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                        ->like('usuario.nombre', $query)
                        ->paginate(7);
        }
        return [];
    }

    // Método para buscar usuarios activos por nombre
    public function buscarUsuariosActivos(string $query) {
        if($query){
            return $this->select('usuario.*, perfil.descripcion as perfil_descripcion')
                        ->join('perfil', 'perfil.id_perfil = usuario.id_perfil')
                        ->like('usuario.nombre', $query)
                        ->where('usuario.baja', 'NO')
                        ->paginate(7);
        }
        return [];
    }

    // Método para buscar usuarios desactivados por nombre
    public function buscarUsuariosDesactivados(string $query) {
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