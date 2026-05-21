<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\models\Usuarios_model;

class Categoria_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function index(){
        $categoriaModel = new Categoria_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();

        $dato['titulo'] = 'Dashboard | Lista de Categorias';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaCategorias', $data);
        echo view('plantillas/footer');
    }

    public function indexDesactivados(){
        $categoriaModel = new Categoria_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();

        $dato['titulo'] = 'Dashboard | Lista de Categorias';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaCategoriasDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function indexParaActivar(){
        $categoriaModel = new Categoria_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();

        $dato['titulo'] = 'Dashboard | Lista de Categorias';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaCategoriasParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function indexActualizarEliminar(){
        $categoriaModel = new Categoria_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();

        $dato['titulo'] = 'Dashboard | Lista de Categorias';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaCategoriasActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function crearCategoria(){
        $dato['titulo'] = 'Dashboard | Agregar Categoria';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeCategorias');
        echo view('plantillas/footer');
    }

    public function actualizarCategoria($id){
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($id);

        $dato['titulo'] = 'Dashboard | Editar Categoria';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarCategorias', $data);
        echo view('plantillas/footer');
    }

    public function eliminarCategoria($id){
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($id);

        $data = ['activo' => 2];
        $categoriaModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Categoría desactivada exitosamente');
        return redirect()->to('/mostrarListaCategoriasActualizarEliminar');
    }

    public function activarCategoria($id){
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($id);

        $data = ['activo' => 1];
        $categoriaModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Categoría activada exitosamente');
        return redirect()->to('/mostrarListaCategoriasParaActivar');
    }

    public function formValidation(){
        $session = session();
        $categoriaDescripcion = $this->request->getVar('categoria');

        $input = $this->validate([
            'categoria' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[categoria.descripcion]'
        ]);

        $formModel = new Categoria_model();

        if(!$input){
            $session->setFlashdata('categoriaValor', $categoriaDescripcion);

            $data['titulo'] = 'Dashboard | Agregar Categoria';
            echo view('plantillas/header', $data);
            echo view('plantillas/nav');
            echo view('back/admin/altaDeCategorias', ['validation' => $this->validator]);
            echo view('plantillas/footer');
        } else{
            $formModel->save([
                'descripcion' => $this->request->getVar('categoria')
            ]);
            session()->setFlashdata('msgExitoso', 'Categoria registrada exitosamente');
            return redirect()->to('/altaDeCategorias');
        }
    }

    public function formValidationUpdate(){
        $id = $this->request->getVar('id');

        $input = $this->validate([
            'id'        => 'required|numeric',
            'categoria' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]|is_unique[categoria.descripcion,id_categoria,' . $id . ']',
        ]);
        if(!$input){
            $categoriaModel = new Categoria_model();
            $data['categoria'] = $categoriaModel->find($this->request->getVar('id'));
            $data['validation'] = $this->validator;

            $dato['titulo'] = 'Dashboard | Editar Categoría';
            echo view('plantillas/header', $dato);
            echo view('plantillas/nav');
            echo view('back/admin/actualizarCategorias', $data);
            echo view('plantillas/footer');
        } else {
            $data = [
                'descripcion' => $this->request->getVar('categoria'),
            ];

            $categoriaModel = new Categoria_model();
            $id = $this->request->getVar('id');
            $categoriaModel->update($id, $data);

            session()->setFlashdata('msgExitoso', 'Categoría actualizada exitosamente');
            return redirect()->to('/mostrarListaCategoriasActualizarEliminar');
        }
    }

    public function limpiarDatos() {
        session()->remove(['categoriaValor']);
        return redirect()->to('/altaDeCategorias');
    }

    public function limpiarDatosAct($id) {
        session()->setFlashdata('limpiarCategoriaValor', true);
        return redirect()->to('/actualizarCategorias/' . $id);
    }
}