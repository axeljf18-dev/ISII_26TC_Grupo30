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

    // MOSTRAR FORMULARIO DE LOGIN
    public function mostrarFormularioLogin(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Inicio de Sesion';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('back/usuario/inicioSesion');
        echo view('plantillas/footer', $dato);
    }

    // RECIBIR DATOS DE FORMULARIO DE LOGIN
    public function recibirDatosFormularioLogin(){
        $correo = $this->request->getVar('email');
        $contraseña = $this->request->getVar('contraseña');
        return $this->validarDatosLogin($correo, $contraseña);
    }

    // VALIDACIÓN DE DATOS DE LOGIN
    public function validarDatosLogin(string $correo, string $contraseña){
        $session = session();

        // reglas validacion 
        $valido = $this->validate([
            'email' => ['label' => 'Correo electrónico', 'rules' => 'required|valid_email'],
            'contraseña' => ['label' => 'Contraseña', 'rules' => 'required']
        ]);

        if(!$valido){
            $session->setFlashdata('emailValor2', $correo);
            $session->setFlashdata('passwordValor2', $contraseña);
            $session->setFlashdata('validationErrors', $this->validator->getErrors());
            return redirect()->to('/inicioSesion');
        }

        // si pasa la validacion, vamos a la autenticación
        return $this->autenticarUsuario($correo, $contraseña);
    }

    // AUTENTICACIÓN DE USUARIO
    private function autenticarUsuario(string $correo, string $contraseña){
        $session = session();
        $model = new Usuarios_model();
        $data = $model->where('email', $correo)->first();

        if($data){
            $pass = $data['pass'];
            $ba = $data['baja'];

            if($ba == 'SI'){
                $session->setFlashdata('msgUser', 'Esta cuenta está dada de baja');
                return redirect()->to('/inicioSesion');
            }

            $verify_pass = password_verify($contraseña, $pass);

            if ($verify_pass) {
                $ses_data = [
                    'id_usuario' => $data['id_usuario'],
                    'nombre' => $data['nombre'],
                    'apellido' => $data['apellido'],
                    'email' => $data['email'],
                    'usuario' => $data['usuario'],
                    'id_perfil' => $data['id_perfil'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data); 

                // redireccion segun el rol del usuario
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
        } else {
            $session->setFlashdata('msgEmail', 'El correo electrónico ingresado es incorrecto');
            $session->setFlashdata('emailValor2', $correo);
            $session->setFlashdata('passwordValor2', $contraseña);
            return redirect()->to('/inicioSesion');
        }
    }

    // LIMPIEZA DE DATOS DE FORMULARIO DE LOGIN
    public function limpiarDatosFormularioLogin() {
        session()->remove(['emailValor2', 'passwordValor2']);
        return redirect()->to('/inicioSesion');
    }

    // CERRAR SESIÓN
    public function cerrarSesion(){
        session()->destroy();
        return redirect()->to('/');
    }
}