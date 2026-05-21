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

    public function listarProductos(){
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosPaginados(7);
        $data['pager'] = $productoModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductos', $data);
        echo view('plantillas/footer');
    }

    public function buscarProductosActivos(){
        $session = session();
        $query = $this->request->getVar('productoQuery'); 
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->buscarProductosActivos($query, 7);
        $data['pager'] = $productoModel->pager;

        $session->setFlashdata('productoQueryValor', $query);
        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductos', $data);
        echo view('plantillas/footer');
    }

    public function listarProductosDesactivados(){
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosDesactivadosPaginados(7);
        $data['pager'] = $productoModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function buscarProductosDesactivados(){
        $session = session();
        $query = $this->request->getVar('productoDesactivadoQuery'); 
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->buscarProductosDesactivados($query, 7);
        $data['pager'] = $productoModel->pager;

        $session->setFlashdata('productoDesactivadoQueryValor', $query);
        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function listarProductosParaActivar(){
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosDesactivadosPaginados(7);
        $data['pager'] = $productoModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function buscarProductosParaActivar(){
        $session = session();
        $query = $this->request->getVar('productoParaActivarQuery');
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->buscarProductosDesactivados($query, 7);
        $data['pager'] = $productoModel->pager;

        $session->setFlashdata('productoParaActivarQueryValor', $query);
        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function listarProductosParaActualizarEliminar(){
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->orderBy('producto.id_producto', 'DESC')->getProductosPaginados(7);
        $data['pager'] = $productoModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function buscarProductosParaActualizarEliminar(){
        $session = session();
        $query = $this->request->getVar('productoActQuery'); 
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel->buscarProductosActivos($query, 7);
        $data['pager'] = $productoModel->pager;

        $session->setFlashdata('productoActQueryValor', $query);
        $dato['titulo'] = 'Dashboard | Lista de Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaProductosActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioCrearProducto(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedorAll();

        $dato['titulo'] = 'Dashboard | Agregar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeProductos', $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioActualizarProducto($id){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id);
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $proveedorModel = new Proveedor_model();
        $data['proveedores'] = $proveedorModel->getProveedorAll();

        $dato['titulo'] = 'Dashboard | Editar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarProductos', $data);
        echo view('plantillas/footer');
    }

    public function desactivarProducto($id){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id);

        $data = ['eliminado' => 'SI'];
        $productoModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Producto desactivado exitosamente');
        return redirect()->to('/mostrarListaProductosActualizarEliminar');
    }

    public function reactivarProducto($id){
        $productoModel = new Producto_model();
        $data['producto'] = $productoModel->find($id);

        $data = ['eliminado' => 'NO'];
        $productoModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'Producto activado exitosamente');
        return redirect()->to('/mostrarListaProductosParaActivar');
    }

    // CREAR PRODUCTO
    private function validarProducto($formulario){
        return $this->validate([
            'nombre'    => 'required|trim|min_length[2]|max_length[50]',
            'categoria' => 'required',
            'marca'     => 'required',
            'precio'    => 'required|trim|numeric|greater_than[0]',
            'precioVta' => 'required|trim|numeric|greater_than[0]',
            'stock'     => 'required|trim|is_natural',
            'stockMin'  => 'required|trim|is_natural',
            'imagen'    => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion' => 'permit_empty|trim|min_length[5]|max_length[255]',
            'proveedor' => 'required'
        ]);
    }

    private function procesarImagen($archivoImagen){
        $nombreAleatorio = $archivoImagen->getRandomName();
        $archivoImagen->move(ROOTPATH . 'assets/uploads', $nombreAleatorio);
        return $nombreAleatorio;
    }

    private function guardarProducto($datosProducto){
        $productoModel = new Producto_model();
        return $productoModel->insert($datosProducto);
    }

    public function registrarProducto(){
        $session = session();

        if(!$this->validarProducto($this->request)){
            $session->setFlashdata('productoValor', $this->request->getVar('nombre'));
            $session->setFlashdata('descripcionProductoValor', $this->request->getVar('descripcion'));
            $session->setFlashdata('categoriaProductoValor', $this->request->getVar('categoria'));
            $session->setFlashdata('marcaProductoValor', $this->request->getVar('marca'));
            $session->setFlashdata('precioProductoValor', $this->request->getVar('precio'));
            $session->setFlashdata('precioVtaProductoValor', $this->request->getVar('precioVta'));
            $session->setFlashdata('stockProductoValor', $this->request->getVar('stock'));
            $session->setFlashdata('stockMinProductoValor', $this->request->getVar('stockMin'));
            $session->setFlashdata('proveedorProductoValor', $this->request->getVar('proveedor'));

            return $this->mostrarFormularioCrearProductoConErrores();
        } else {
            $img = $this->request->getFile('imagen');
            $nombreImagen = $this->procesarImagen($img);

            $datos = [
                'nombre'       => $this->request->getVar('nombre'),
                'imagen'       => $nombreImagen,
                'id_categoria' => $this->request->getVar('categoria'),
                'precio'       => $this->request->getVar('precio'),
                'precio_vta'   => $this->request->getVar('precioVta'),
                'stock'        => $this->request->getVar('stock'),
                'stock_min'    => $this->request->getVar('stockMin'),
                'descripcion'  => $this->request->getVar('descripcion'),
                'id_marca'     => $this->request->getVar('marca'),
                'id_proveedor' => $this->request->getVar('proveedor')
            ];

            $this->guardarProducto($datos);
            $session->setFlashdata('msgExitoso', 'Producto registrado exitosamente');
            return $this->response->redirect(site_url('altaDeProductos'));
        }
    }

    private function mostrarFormularioCrearProductoConErrores(){
        $categoriaModel = new Categoria_model();
        $marcaModel = new Marca_model();
        $proveedorModel = new Proveedor_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $data['proveedores'] = $proveedorModel->getProveedorAll();
        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Agregar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeProductos', $data);
        echo view('plantillas/footer');
    }

    // ACTUALIZAR PRODUCTO
    private function validarProductoUpdate($formulario){
        return $this->validate([
            'id'        => 'required|numeric',
            'nombre'    => 'required|trim|min_length[2]|max_length[50]',
            'categoria' => 'required',
            'precio'    => 'required|trim|numeric|greater_than[0]',
            'precioVta' => 'required|trim|numeric|greater_than[0]',
            'stock'     => 'required|trim|is_natural',
            'stockMin'  => 'required|trim|is_natural',
            'imagen'    => 'max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion' => 'permit_empty|trim|min_length[5]|max_length[255]',
            'marca'     => 'required',
            'proveedor' => 'required'
        ]);
    }

    private function procesarImagenUpdate($archivoImagen){
        if ($archivoImagen->isValid() && !$archivoImagen->hasMoved()) {
            $nombreAleatorio = $archivoImagen->getRandomName();
            $archivoImagen->move(ROOTPATH . 'assets/uploads', $nombreAleatorio);
            return $nombreAleatorio;
        }
        return null;
    }

    private function guardarProductoActualizado($id, $datosProducto){
        $productoModel = new Producto_model();
        return $productoModel->update($id, $datosProducto);
    }

    public function actualizarProducto(){
        $session = session();
        $id = $this->request->getVar('id');

        if(!$this->validarProductoUpdate($this->request)){
            return $this->mostrarFormularioActualizarProductoConErrores($id);
        }

        $nombreImagen = $this->procesarImagenUpdate($this->request->getFile('imagen'));

        $datosProducto = [
            'id_producto'   => $id,
            'nombre'        => $this->request->getVar('nombre'),
            'id_categoria'  => $this->request->getVar('categoria'),
            'precio'        => $this->request->getVar('precio'),
            'precio_vta'    => $this->request->getVar('precioVta'),
            'stock'         => $this->request->getVar('stock'),
            'stock_min'     => $this->request->getVar('stockMin'),
            'descripcion'   => $this->request->getVar('descripcion'),
            'id_marca'      => $this->request->getVar('marca'),
            'id_proveedor'  => $this->request->getVar('proveedor')
        ];

        if($nombreImagen){
            $datosProducto['imagen'] = $nombreImagen;
        }

        $this->guardarProductoActualizado($id, $datosProducto);
        $session->setFlashdata('msgExitoso', 'Producto actualizado exitosamente');
        return $this->response->redirect(site_url('mostrarListaProductosActualizarEliminar'));
    }

    private function mostrarFormularioActualizarProductoConErrores($id){
        $productoModel = new Producto_model();
        $categoriaModel = new Categoria_model();
        $marcaModel = new Marca_model();
        $proveedorModel = new Proveedor_model();

        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $data['producto'] = $productoModel->find($id);
        $data['proveedores'] = $proveedorModel->getProveedorAll();
        $data['validation'] = $this->validator;

        $dato['titulo'] = 'Dashboard | Editar Producto';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarProductos', $data);
        echo view('plantillas/footer');
    }

    public function limpiarFormularioAltaProducto() {
        session()->remove(['productoValor', 'descripcionProductoValor', 'categoriaProductoValor', 'marcaProductoValor', 'precioProductoValor', 'precioVtaProductoValor', 'stockProductoValor', 'stockMinProductoValor']);
        return redirect()->to('/altaDeProductos');
    }

    public function limpiarFormularioActualizarProducto($id) {
        session()->setFlashdata('limpiarProductoValor', true);
        session()->setFlashdata('limpiarImagenValor', true);
        return redirect()->to('/actualizarProductos/' . $id);
    }
}