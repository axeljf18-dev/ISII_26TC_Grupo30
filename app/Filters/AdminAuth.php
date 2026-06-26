<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null){
        if(session()->get('logged_in')){
            $sesion = session();
            $perfil = $sesion->get('id_perfil');

            if ($perfil == 1) {
                return redirect()->to('/mostrarListaProductos');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }
}