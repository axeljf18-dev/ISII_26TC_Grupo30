<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Direccion_model;
use App\Models\Localidad_model;
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

        $hayProductosTotales = $productoModel->countAllResults() > 0;

        switch($estadoProductos){
            case 'desactivados':
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosDesactivados();
                $vista = 'back/admin/listaProductosDesactivados';
                break;
            case 'actualizarEliminar':
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->verificarProductos();
                $vista = 'back/admin/listaProductosActualizarEliminar';
                break;
            default: // activos
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosActivados();
                $vista = 'back/admin/listaProductos';
                break;
        }

        $data['hayProductosTotales'] = $hayProductosTotales;
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

        $hayProductosTotales = $productoModel->countAllResults() > 0;

        switch($estadoProductos){
            case 'desactivados':
                $query = $this->request->getVar('productoDesactivadoQuery');
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->buscarProductosDesactivados($query);
                $session->setFlashdata('productoDesactivadoQueryValor', $query);
                $vista = 'back/admin/listaProductosDesactivados';
                break;
            case 'actualizarEliminar':
                $query = $this->request->getVar('productoActQuery');
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->buscarProductosAll($query);
                $session->setFlashdata('productoActQueryValor', $query);
                $vista = 'back/admin/listaProductosActualizarEliminar';
                break;
            default: // activos
                $query = $this->request->getVar('productoQuery');
                $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->buscarProductosActivos($query);
                $session->setFlashdata('productoQueryValor', $query);
                $vista = 'back/admin/listaProductos';
                break;
        }

        $data['hayProductosTotales'] = $hayProductosTotales;
        $data['pager'] = $productoModel->pager;
        $dato['titulo'] = 'Dashboard | Lista de Productos';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view($vista, $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioCrearProducto(){
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedoresActivos();

        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Agregar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeProductos', $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioActualizarProducto($idProducto){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($idProducto);
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedoresActivos();

        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Editar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarProductos', $data);
        echo view('plantillas/footer');
    }

    public function mostrarMensajeConfirmacion($idProducto, $accion) {
        $productoModel = new Producto_model();
        $producto = $productoModel->find($idProducto);

        $dato['titulo'] = 'Dashboard | Confirmar acción';
        echo view('plantillas/header', $dato);
        echo view('back/admin/confirmacionProducto', ['producto' => $producto, 'accion' => $accion]);
        echo view('plantillas/footer');
    }

    public function desactivarProducto($idProducto){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($idProducto);

        $data = ['eliminado' => 'SI'];
        $productoModel->update($idProducto, $data);

        session()->setFlashdata('msgExitoso', 'Producto desactivado correctamente');
        return redirect()->to('/mostrarListaProductosActualizarEliminar');
    }

    public function reactivarProducto($idProducto){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($idProducto);

        $data = ['eliminado' => 'NO'];
        $productoModel->update($idProducto, $data);

        session()->setFlashdata('msgExitoso', 'Producto activado correctamente');
        return redirect()->to('/mostrarListaProductosActualizarEliminar');
    }

    public function recibirDatosFormularioProducto(){
        $datos = $this->request;

        // Si el formulario trae un id, significa que es actualización
        if ($datos->getPost('id')) {
            return $this->validarDatosProductoActualizar($datos);
        } else {
            return $this->validarDatosProducto($datos);
        }
    }

    // CREAR PRODUCTO
    public function validarDatosProducto($datos){
        $session = session();

        $valido = $this->validate([
            'nombre' => ['label' => 'Nombre del producto', 'rules' => 'required|trim|min_length[2]|max_length[50]'],
            'precio' => ['label' => 'Precio', 'rules' => 'required|trim|numeric|greater_than[0]'],
            'precioVta' => ['label' => 'Precio de venta', 'rules' => 'required|trim|numeric|greater_than[0]'],
            'stock' => ['label' => 'Stock', 'rules' => 'required|trim|is_natural'],
            'stockMin' => ['label' => 'Stock mínimo', 'rules' => 'required|trim|is_natural'],
            'imagen' => ['label' => 'Imagen', 'rules' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]'],
            'descripcion' => ['label' => 'Descripción', 'rules' => 'permit_empty|trim|min_length[5]|max_length[255]']
        ], $datos->getPost());

        $marcaModel = new Marca_model();
        $categoriaModel = new Categoria_model();
        $proveedorModel = new Proveedor_model();

        if(!$marcaModel->validarMarca($datos->getVar('marca'))){
            $this->validator->setError('marca', 'La Marca seleccionada no es válida.');
            $valido = false;
        }

        if(!$categoriaModel->validarCategoria($datos->getVar('categoria'))){
            $this->validator->setError('categoria', 'La Categoría seleccionada no es válida.');
            $valido = false;
        }

        if(!$proveedorModel->validarProveedor($datos->getVar('proveedor'))){
            $this->validator->setError('proveedor', 'El Proveedor seleccionado no existe.');
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
            'nombre' => $datosProducto->getVar('nombre'),
            'imagen' => $nombreImagen,
            'id_categoria' => $datosProducto->getVar('categoria'),
            'precio' => $datosProducto->getVar('precio'),
            'precio_vta' => $datosProducto->getVar('precioVta'),
            'stock' => $datosProducto->getVar('stock'),
            'stock_min' => $datosProducto->getVar('stockMin'),
            'descripcion' => $datosProducto->getVar('descripcion'),
            'id_marca' => $datosProducto->getVar('marca'),
            'id_proveedor' => $datosProducto->getVar('proveedor')
        ];

        $productoModel = new Producto_model();
        $productoModel->insert($datos);

        $session->setFlashdata('msgExitoso', 'Producto creado correctamente');
        return $this->response->redirect(site_url('altaDeProductos'));
    }

    // ACTUALIZAR PRODUCTO
    public function validarDatosProductoActualizar($datos){
        $session = session();

        $valido = $this->validate([
            'id' => ['label' => 'ID del producto', 'rules' => 'required|numeric'],
            'nombre' => ['label' => 'Nombre del producto', 'rules' => 'required|trim|min_length[2]|max_length[50]'],
            'precio' => ['label' => 'Precio', 'rules' => 'required|trim|numeric|greater_than[0]'],
            'precioVta' => ['label' => 'Precio de venta', 'rules' => 'required|trim|numeric|greater_than[0]'],
            'stock' => ['label' => 'Stock', 'rules' => 'required|trim|is_natural'],
            'stockMin' => ['label' => 'Stock mínimo', 'rules' => 'required|trim|is_natural'],
            'imagen' => ['label' => 'Imagen', 'rules' => 'max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]'],
            'descripcion' => ['label' => 'Descripción', 'rules' => 'permit_empty|trim|min_length[5]|max_length[255]']
        ], $datos->getPost());

        $marcaModel = new Marca_model();
        $categoriaModel = new Categoria_model();
        $proveedorModel = new Proveedor_model();

        if(!$marcaModel->validarMarca($datos->getVar('marca'))){
            $this->validator->setError('marca', 'La Marca seleccionada no es válida.');
            $valido = false;
        }

        if(!$categoriaModel->validarCategoria($datos->getVar('categoria'))){
            $this->validator->setError('categoria', 'La Categoría seleccionada no es válida.');
            $valido = false;
        }

        if(!$proveedorModel->validarProveedor($datos->getVar('proveedor'))){
            $this->validator->setError('proveedor', 'El Proveedor seleccionado no existe.');
            $valido = false;
        }

        if(!$valido){
            return $this->mostrarFormularioActualizarProducto($datos->getVar('id'));
        }else{
            return $this->guardarProductoActualizado($datos->getVar('id'), $datos);
        }
    }

    private function guardarProductoActualizado($idProducto, $datosProducto){
        $session = session();

        $img = $datosProducto->getFile('imagen');
        $nombreImagen = null;
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $nombreImagen = $img->getRandomName();
            $img->move(ROOTPATH . 'assets/uploads', $nombreImagen);
        }

        $datos = [
            'id_producto' => $idProducto,
            'nombre' => $datosProducto->getVar('nombre'),
            'id_categoria' => $datosProducto->getVar('categoria'),
            'precio' => $datosProducto->getVar('precio'),
            'precio_vta' => $datosProducto->getVar('precioVta'),
            'stock' => $datosProducto->getVar('stock'),
            'stock_min' => $datosProducto->getVar('stockMin'),
            'descripcion' => $datosProducto->getVar('descripcion'),
            'id_marca' => $datosProducto->getVar('marca'),
            'id_proveedor' => $datosProducto->getVar('proveedor')
        ];

        if($nombreImagen){
            $datos['imagen'] = $nombreImagen;
        }

        $productoModel = new Producto_model();
        $productoModel->update($idProducto, $datos);

        $session->setFlashdata('msgExitoso', 'Los datos del producto se han guardado correctamente');
        return $this->response->redirect(site_url('mostrarListaProductosActualizarEliminar'));
    }

    public function limpiarDatosFormularioProducto($idProducto = null) {
        $session = session();

        if ($idProducto === null) { // Del formulario alta de producto
            $session->remove(['productoValor', 'descripcionProductoValor', 'categoriaProductoValor', 'marcaProductoValor', 'precioProductoValor', 'precioVtaProductoValor', 'stockProductoValor', 'stockMinProductoValor']);
            return redirect()->to('/altaDeProductos');
        } else { // Del formulario actualizar un producto
            $session->setFlashdata('limpiarProductoValor', true);
            $session->setFlashdata('limpiarImagenValor', true);
            return redirect()->to('/actualizarProductos/' . $idProducto);
        }
    }
}