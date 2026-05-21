<?php
namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\Usuarios_model;
use CodeIgniter\Controller;

class Login_controller extends Controller{
    public function index(){
        helper(['form', 'url']);
    }

    public function inicioSesion(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Inicio de Sesion';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('back/usuario/inicioSesion');
        echo view('plantillas/footer', $dato);
    }

    public function formValidation(){
        $session = session();
        $model = new Usuarios_model();

        $correo = $this->request->getVar('email');
        $contraseña = $this->request->getVar('contraseña');

        $data = $model->where('email', $correo)->first();

        if($data){
            $pass = $data['pass'];
            $ba = $data['baja'];

            if($ba == 'SI'){
                $session->setFlashdata('msgUser', 'El usuario esta dado de baja');
                return redirect()->to('/inicioSesion');
            }

            // Se verifica la contraseña utilizando password_verify.
            $verify_pass = password_verify($contraseña, $pass);
            if ($verify_pass) {
                // Se prepara la información a guardar en la sesión.
                $ses_data = [
                    'id_usuario'  => $data['id_usuario'],
                    'nombre'      => $data['nombre'],
                    'apellido'    => $data['apellido'],
                    'email'       => $data['email'],
                    'usuario'     => $data['usuario'],
                    'id_perfil'   => $data['id_perfil'],
                    'logged_in'   => TRUE
                ];
                $session->set($ses_data); 
                if ($data['id_perfil'] == 1) { 
                    return redirect()->to('/mostrarListaProductos');
                } elseif ($data['id_perfil'] == 2) {
                    return redirect()->to('/');
                } else {
                    return redirect()->to('/inicioSesion');
                }
            } else {
                $session->setFlashdata('msgPassword', 'La contraseña ingresada es incorrecta');
                $session->setFlashdata('emailValor2', $correo);
                $session->setFlashdata('passwordValor2', $contraseña);
                return redirect()->to('/inicioSesion');
            }
        } else{
            $session->setFlashdata('msgEmail', 'El correo electrónico ingresado es incorrecto');
            $session->setFlashdata('emailValor2', $correo);
            $session->setFlashdata('passwordValor2', $contraseña);
            return redirect()->to('/inicioSesion');
        }
    }

    public function limpiarDatos() {
        session()->remove(['emailValor2', 'passwordValor2']);
        return redirect()->to('/inicioSesion');
    }

    public function logeout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}