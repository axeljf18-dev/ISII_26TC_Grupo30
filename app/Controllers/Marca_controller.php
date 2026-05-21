<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\models\Usuarios_model;

class Marca_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function index(){
        $marcaModel = new Marca_model();

        $data['marcas'] = $marcaModel->getMarcaAll();

        $dato['titulo'] = 'Dashboard | Lista de Marcas';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaMarcas', $data);
        echo view('plantillas/footer');
    }

    public function indexDesactivados(){
        $marcaModel = new Marca_model();

        $data['marcas'] = $marcaModel->getMarcaAll();

        $dato['titulo'] = 'Dashboard | Lista de Marcas';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaMarcasDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function indexParaActivar(){
        $marcaModel = new Marca_model();

        $data['marcas'] = $marcaModel->getMarcaAll();

        $dato['titulo'] = 'Dashboard | Lista de Marcas';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaMarcasParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function indexActualizarEliminar(){
        $marcaModel = new Marca_model();

        $data['marcas'] = $marcaModel->getMarcaAll();

        $dato['titulo'] = 'Dashboard | Lista de Marcas';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaMarcasActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function crearMarca(){
        $dato['titulo'] = 'Dashboard | Agregar Marca';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeMarcas');
        echo view('plantillas/footer');
    }

    public function actualizarMarca($id){
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($id);

        $dato['titulo'] = 'Dashboard | Editar Marca';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarMarcas', $data);
        echo view('plantillas/footer');
    }

    public function eliminarMarca($id){
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($id);

        $data = ['activo' => 2];
        $marcaModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Marca desactivada exitosamente');
        return redirect()->to('/mostrarListaMarcasActualizarEliminar');
    }

    public function activarMarca($id){
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($id);

        $data = ['activo' => 1];
        $marcaModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Marca activada exitosamente');
        return redirect()->to('/mostrarListaMarcasParaActivar');
    }

    public function formValidation(){
        $session = session();
        $MarcaDescripcion = $this->request->getVar('marca');

        $input = $this->validate([
            'marca' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[marca.descripcion]'
        ]);

        $formModel = new Marca_model();

        if(!$input){
            $session->setFlashdata('marcaDescripcionValor', $MarcaDescripcion);

            $data['titulo'] = 'Dashboard | Agregar Marca';
            echo view('plantillas/header', $data);
            echo view('plantillas/nav');
            echo view('back/admin/altaDeMarcas', ['validation' => $this->validator]);
            echo view('plantillas/footer');
        } else{
            $formModel->save([
                'descripcion' => $this->request->getVar('marca')
            ]);
            session()->setFlashdata('msgExitoso', 'Marca registrada exitosamente');
            return redirect()->to('/altaDeMarcas');
        }
    }

    public function formValidationUpdate(){
        $id = $this->request->getVar('id');

        $input = $this->validate([
            'id'        => 'required|numeric',
            'marca'     => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[marca.descripcion,id_marca,' . $id . ']',
        ]);
        if(!$input){
            $marcaModel = new Marca_model();
            $data['marca'] = $marcaModel->find($this->request->getVar('id'));
            $data['validation'] = $this->validator;

            $dato['titulo'] = 'Dashboard | Editar Marca';
            echo view('plantillas/header', $dato);
            echo view('plantillas/nav');
            echo view('back/admin/actualizarMarcas', $data);
            echo view('plantillas/footer');
        } else {
            $data = [
                'descripcion' => $this->request->getVar('marca'),
            ];

            $marcaModel = new Marca_model();
            $id = $this->request->getVar('id');
            $marcaModel->update($id, $data);

            session()->setFlashdata('msgExitoso', 'Marca actualizada exitosamente');
            return redirect()->to('/mostrarListaMarcasActualizarEliminar');
        }
    }

    public function limpiarDatos() {
        session()->remove(['perfilDescripcionValor']);
        return redirect()->to('/altaDeMarcas');
    }

    public function limpiarDatosAct($id) {
        session()->setFlashdata('limpiarMarcaValor', true);
        return redirect()->to('/actualizarMarcas/' . $id);
    }
}