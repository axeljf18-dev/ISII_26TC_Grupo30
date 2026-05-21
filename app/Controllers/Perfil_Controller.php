<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Perfil_model;
use App\models\Usuarios_model;

class Perfil_Controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function index(){
        $perfilModel = new Perfil_model();

        $data['perfiles'] = $perfilModel->getPerfilAll();

        $dato['titulo'] = 'Dashboard | Lista de Perfiles';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaPerfiles', $data);
        echo view('plantillas/footer');
    }

    public function indexDesactivados(){
        $perfilModel = new Perfil_model();

        $data['perfiles'] = $perfilModel->getPerfilAll();

        $dato['titulo'] = 'Dashboard | Lista de Perfiles';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaPerfilesDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function indexParaActivar(){
        $perfilModel = new Perfil_model();

        $data['perfiles'] = $perfilModel->getPerfilAll();

        $dato['titulo'] = 'Dashboard | Lista de Perfiles';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaPerfilesParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function indexActualizarEliminar(){
        $perfilModel = new Perfil_model();

        $data['perfiles'] = $perfilModel->getPerfilAll();

        $dato['titulo'] = 'Dashboard | Lista de Perfiles';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaPerfilesActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function crearPerfil(){
        $dato['titulo'] = 'Dashboard | Agregar Perfil';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDePerfiles');
        echo view('plantillas/footer');
    }

    public function actualizarPerfil($id){
        $perfilModel = new Perfil_model();
        $data['perfil'] = $perfilModel->find($id);

        $dato['titulo'] = 'Dashboard | Editar Perfil';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarPerfiles', $data);
        echo view('plantillas/footer');
    }

    public function eliminarPerfil($id){
        $perfilModel = new Perfil_model();
        $data['perfil'] = $perfilModel->find($id);

        $data = ['baja' => 'SI'];
        $perfilModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Perfil desactivado exitosamente');
        return redirect()->to('/mostrarListaPerfilesActualizarEliminar');
    }

    public function activarPerfil($id){
        $perfilModel = new Perfil_model();
        $data['perfil'] = $perfilModel->find($id);

        $data = ['baja' => 'NO'];
        $perfilModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Perfil activado exitosamente');
        return redirect()->to('/mostrarListaPerfilesParaActivar');
    }

    public function formValidation(){
        $session = session();
        $perfilDescripcion = $this->request->getVar('perfil');

        $input = $this->validate([
            'perfil' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[perfil.descripcion]'
        ]);

        $formModel = new Perfil_model();

        if(!$input){
            $session->setFlashdata('perfilDescripcionValor', $perfilDescripcion);

            $data['titulo'] = 'Dashboard | Agregar Perfil';
            echo view('plantillas/header', $data);
            echo view('plantillas/nav');
            echo view('back/admin/altaDePerfiles', ['validation' => $this->validator]);
            echo view('plantillas/footer');

        } else{
            $formModel->save([
                'descripcion' => $this->request->getVar('perfil')
            ]);

            session()->setFlashdata('msgExitoso', 'Perfil registrado exitosamente');
            return redirect()->to('/altaDePerfiles');
        }
    }

    public function formValidationUpdate(){
        $id = $this->request->getVar('id');

        $input = $this->validate([
            'id' => 'required|numeric',
            'perfil' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[perfil.descripcion,id_perfil,' . $id . ']',
        ]);
        if(!$input){
            $perfilModel = new Perfil_model();
            $data['perfil'] = $perfilModel->find($this->request->getVar('id'));
            $data['validation'] = $this->validator;

            $dato['titulo'] = 'Dashboard | Editar Perfil';
            echo view('plantillas/header', $dato);
            echo view('plantillas/nav');
            echo view('back/admin/actualizarPerfiles', $data);
            echo view('plantillas/footer');
        } else {
            $data = [
                'descripcion' => $this->request->getVar('perfil'),
            ];

            $perfilModel = new Perfil_model();
            $id = $this->request->getVar('id');
            $perfilModel->update($id, $data);

            session()->setFlashdata('msgExitoso', 'Perfil actualizado exitosamente');
            return redirect()->to('/mostrarListaPerfilesActualizarEliminar');
        }
    }

    public function limpiarDatos() {
        session()->remove(['perfilDescripcionValor']);
        return redirect()->to('/altaDePerfiles');
    }

    public function limpiarDatosAct($id) {
        session()->setFlashdata('limpiarPerfilValor', true);
        return redirect()->to('/actualizarPerfiles/' . $id);
    }
}