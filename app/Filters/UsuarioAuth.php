<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UsuarioAuth implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null){
        if(!session()->get('logged_in')){
            return redirect()->to('/inicioSesion');
        } else{
            // El usuario(cliente) está logueado, ahora verificamos el rol.
            $sesion = session();
            $perfil = $sesion->get('id_perfil');

            if ($perfil == 2) {
                return redirect()->to('/');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }
}