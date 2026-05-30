<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\Proveedor_model;
use App\models\Usuarios_model;

class Producto_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function listarProductos($estadoProductos){
        $productoModel = new Producto_model();

        switch($estadoProductos){
            case 'desactivados':
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosDesactivadosPaginados(7);
                $vista = 'back/admin/listaProductosDesactivados';
                break;
            case 'paraActivar':
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosDesactivadosPaginados(7);
                $vista = 'back/admin/listaProductosParaActivar';
                break;
            case 'actualizarEliminar':
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosPaginados(7);
                $vista = 'back/admin/listaProductosActualizarEliminar';
                break;
            default: // activos
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosPaginados(7);
                $vista = 'back/admin/listaProductos';
                break;
        }

        $data['pager'] = $productoModel->pager;
        $dato['titulo'] = 'Dashboard | Lista de Productos';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view($vista, $data);
        echo view('plantillas/footer');
    }

    public function buscarProductos($estadoProductos){
        $session = session();
        $productoModel = new Producto_model();

        switch($estadoProductos){
            case 'desactivados':
                $query = $this->request->getVar('productoDesactivadoQuery');
                $data['productos'] = $productoModel->buscarProductosDesactivados($query, 7);
                $session->setFlashdata('productoDesactivadoQueryValor', $query);
                $vista = 'back/admin/listaProductosDesactivados';
                break;
            case 'paraActivar':
                $query = $this->request->getVar('productoParaActivarQuery');
                $data['productos'] = $productoModel->buscarProductosDesactivados($query, 7);
                $session->setFlashdata('productoParaActivarQueryValor', $query);
                $vista = 'back/admin/listaProductosParaActivar';
                break;
            case 'actualizarEliminar':
                $query = $this->request->getVar('productoActQuery');
                $data['productos'] = $productoModel->buscarProductosActivos($query, 7);
                $session->setFlashdata('productoActQueryValor', $query);
                $vista = 'back/admin/listaProductosActualizarEliminar';
                break;
            default: // activos
                $query = $this->request->getVar('productoQuery');
                $data['productos'] = $productoModel->buscarProductosActivos($query, 7);
                $session->setFlashdata('productoQueryValor', $query);
                $vista = 'back/admin/listaProductos';
                break;
        }

        $data['pager'] = $productoModel->pager;
        $dato['titulo'] = 'Dashboard | Lista de Productos';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view($vista, $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioCrearProducto(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedoresActivos();

        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Agregar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeProductos', $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioActualizarProducto($id_producto){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id_producto);
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedoresActivos();

        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Editar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarProductos', $data);
        echo view('plantillas/footer');
    }

    public function desactivarProducto($id_producto){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id_producto);

        $data = ['eliminado' => 'SI'];
        $productoModel->update($id_producto, $data);

        session()->setFlashdata('msgExitoso', 'Producto desactivado exitosamente');
        return redirect()->to('/mostrarListaProductosActualizarEliminar');
    }

    public function reactivarProducto($id_producto){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id_producto);

        $data = ['eliminado' => 'NO'];
        $productoModel->update($id_producto, $data);

        session()->setFlashdata('msgExitoso', 'Producto activado exitosamente');
        return redirect()->to('/mostrarListaProductosParaActivar');
    }

    // CREAR PRODUCTO
    public function validarDatosProducto($datos = null){
        $session = session();

        if ($datos === null) {
            $datos = $this->request;
        }

        $valido = $this->validate([
            'nombre'    => 'required|trim|min_length[2]|max_length[50]',
            'precio'    => 'required|trim|numeric|greater_than[0]',
            'precioVta' => 'required|trim|numeric|greater_than[0]',
            'stock'     => 'required|trim|is_natural',
            'stockMin'  => 'required|trim|is_natural',
            'imagen'    => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion' => 'permit_empty|trim|min_length[5]|max_length[255]',
        ]);

        $marcaModel = new Marca_model();
        $categoriaModel = new Categoria_model();
        $proveedorModel = new Proveedor_model();

        if(!$marcaModel->validarMarca($datos->getVar('marca'))){
            $this->validator->setError('marca', 'La marca seleccionada no es válida o está inactiva.');
            $valido = false;
        }

        if(!$categoriaModel->validarCategoria($datos->getVar('categoria'))){
            $this->validator->setError('categoria', 'La categoría seleccionada no es válida o está inactiva.');
            $valido = false;
        }

        if(!$proveedorModel->validarProveedor($datos->getVar('proveedor'))){
            $this->validator->setError('proveedor', 'El proveedor seleccionado no existe.');
            $valido = false;
        }

        if(!$valido){
            $session->setFlashdata('productoValor', $datos->getVar('nombre'));
            $session->setFlashdata('descripcionProductoValor', $datos->getVar('descripcion'));
            $session->setFlashdata('categoriaProductoValor', $datos->getVar('categoria'));
            $session->setFlashdata('marcaProductoValor', $datos->getVar('marca'));
            $session->setFlashdata('precioProductoValor', $datos->getVar('precio'));
            $session->setFlashdata('precioVtaProductoValor', $datos->getVar('precioVta'));
            $session->setFlashdata('stockProductoValor', $datos->getVar('stock'));
            $session->setFlashdata('stockMinProductoValor', $datos->getVar('stockMin'));
            $session->setFlashdata('proveedorProductoValor', $datos->getVar('proveedor'));

            return $this->mostrarFormularioCrearProducto();
        }else{
            return $this->guardarProducto($datos);
        }
    }

    private function guardarProducto($datosProducto){
        $session = session();

        $img = $datosProducto->getFile('imagen');
        $nombreImagen = $img->getRandomName();
        $img->move(ROOTPATH . 'assets/uploads', $nombreImagen);

        $datos = [
            'nombre'       => $datosProducto->getVar('nombre'),
            'imagen'       => $nombreImagen,
            'id_categoria' => $datosProducto->getVar('categoria'),
            'precio'       => $datosProducto->getVar('precio'),
            'precio_vta'   => $datosProducto->getVar('precioVta'),
            'stock'        => $datosProducto->getVar('stock'),
            'stock_min'    => $datosProducto->getVar('stockMin'),
            'descripcion'  => $datosProducto->getVar('descripcion'),
            'id_marca'     => $datosProducto->getVar('marca'),
            'id_proveedor' => $datosProducto->getVar('proveedor')
        ];

        $productoModel = new Producto_model();
        $productoModel->insert($datos);

        $session->setFlashdata('msgExitoso', 'Producto registrado exitosamente');
        return $this->response->redirect(site_url('altaDeProductos'));
    }

    // ACTUALIZAR PRODUCTO
    public function validarDatosProductoActualizar($datos = null){
        $session = session();

        if ($datos === null) {
            $datos = $this->request;
        }

        $valido = $this->validate([
            'id'        => 'required|numeric',
            'nombre'    => 'required|trim|min_length[2]|max_length[50]',
            'precio'    => 'required|trim|numeric|greater_than[0]',
            'precioVta' => 'required|trim|numeric|greater_than[0]',
            'stock'     => 'required|trim|is_natural',
            'stockMin'  => 'required|trim|is_natural',
            'imagen'    => 'max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion' => 'permit_empty|trim|min_length[5]|max_length[255]',
        ]);

        $marcaModel = new Marca_model();
        $categoriaModel = new Categoria_model();
        $proveedorModel = new Proveedor_model();

        if(!$marcaModel->validarMarca($datos->getVar('marca'))){
            $this->validator->setError('marca', 'La marca seleccionada no es válida o está inactiva.');
            $valido = false;
        }

        if(!$categoriaModel->validarCategoria($datos->getVar('categoria'))){
            $this->validator->setError('categoria', 'La categoría seleccionada no es válida o está inactiva.');
            $valido = false;
        }

        if(!$proveedorModel->validarProveedor($datos->getVar('proveedor'))){
            $this->validator->setError('proveedor', 'El proveedor seleccionado no existe.');
            $valido = false;
        }

        if(!$valido){
            return $this->mostrarFormularioActualizarProducto($datos->getVar('id'));
        }else{
            return $this->guardarProductoActualizado($datos->getVar('id'), $datos);
        }
    }

    private function guardarProductoActualizado($id_producto, $datosProducto){
        $session = session();

        $img = $datosProducto->getFile('imagen');
        $nombreImagen = null;
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nombreImagen = $img->getRandomName();
            $img->move(ROOTPATH . 'assets/uploads', $nombreImagen);
        }

        $datos = [
            'id_producto'   => $id_producto,
            'nombre'        => $datosProducto->getVar('nombre'),
            'id_categoria'  => $datosProducto->getVar('categoria'),
            'precio'        => $datosProducto->getVar('precio'),
            'precio_vta'    => $datosProducto->getVar('precioVta'),
            'stock'         => $datosProducto->getVar('stock'),
            'stock_min'     => $datosProducto->getVar('stockMin'),
            'descripcion'   => $datosProducto->getVar('descripcion'),
            'id_marca'      => $datosProducto->getVar('marca'),
            'id_proveedor'  => $datosProducto->getVar('proveedor')
        ];

        if($nombreImagen){
            $datos['imagen'] = $nombreImagen;
        }

        $productoModel = new Producto_model();
        $productoModel->update($id_producto, $datos);

        $session->setFlashdata('msgExitoso', 'Producto actualizado exitosamente');
        return $this->response->redirect(site_url('mostrarListaProductosActualizarEliminar'));
    }

    public function limpiarDatosFormularioProducto($id = null) {
        $session = session();

        if ($id === null) { // Del formulario alta de producto
            $session->remove(['productoValor', 'descripcionProductoValor', 'categoriaProductoValor', 'marcaProductoValor', 'precioProductoValor', 'precioVtaProductoValor', 'stockProductoValor', 'stockMinProductoValor']);
            return redirect()->to('/altaDeProductos');
        } else { // Del formulario actualizar un producto
            $session->setFlashdata('limpiarProductoValor', true);
            $session->setFlashdata('limpiarImagenValor', true);
            return redirect()->to('/actualizarProductos/' . $id);
        }
    }
}