<?php

namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\MetodoPago_model;
use App\Models\Producto_model;
use CodeIgniter\CLI\Console;

class Home extends BaseController
{
    public function inicio(){
        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        
        $data['titulo'] = 'NetShop | Principal';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/carrusel');
        echo view('plantillas/index', $data);
        echo view('plantillas/footer', $data);
    }

    public function buscador(){
        $session = session();
        $query = $this->request->getVar('query'); 
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();
        $data['productosTotal'] = $productoModel->getProductosConMarcaYCategoria();
        $productoModel = new Producto_model();

        $data['productos'] = $query ? $this->buscarProductos($query) : [];

        $session->set('queryValor', $query);
        $dato['titulo'] = 'NetShop | Productos';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav', $data);
        echo view('plantillas/productosBuscados', $data);
        echo view('plantillas/footer', $data);
    }

    private function buscarProductos($query){
        $productoModel = new Producto_model();

        return $productoModel
            ->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
            ->join('marca', 'marca.id_marca = producto.id_marca')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->like('producto.nombre', $query)
            ->where('producto.eliminado', 'NO')
            ->where('marca.activo', 1)
            ->where('categoria.activo', 1)
            ->findAll();
    }

    private function mostrarProductosBuscados($data){
        $data['titulo'] = 'NetShop | Productos';

        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/productosBuscados', $data);
        echo view('plantillas/footer', $data);
    }

    public function buscarPorRangoPrecioBuscador($valor){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();

        if (is_numeric($precioMin) && is_numeric($precioMax)) {
            $data['productos'] = $productoModel
                ->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                ->join('marca', 'marca.id_marca = producto.id_marca')
                ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                ->like('producto.nombre', $valor)
                ->where('producto.precio >=', $precioMin)
                ->where('producto.precio <=', $precioMax)
                ->where('producto.eliminado', 'NO')
                ->where('marca.activo', 1)
                ->where('categoria.activo', 1)
                ->findAll();
        } else {
            $data['productos'] = [];
        }

        $this->mostrarProductosBuscados($data);
    }

    public function ordenarProductosPorMayorPrecioBuscador($valor){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel
            ->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
            ->join('marca', 'marca.id_marca = producto.id_marca')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->like('producto.nombre', $valor)
            ->where('producto.eliminado', 'NO')
            ->where('marca.activo', 1)
            ->where('categoria.activo', 1)
            ->orderBy('producto.precio', 'DESC')
            ->findAll();

        $this->mostrarProductosBuscados($data);
    }

    public function ordenarProductosPorMenorPrecioBuscador($valor){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll(); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel
            ->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
            ->join('marca', 'marca.id_marca = producto.id_marca')
            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
            ->like('producto.nombre', $valor)
            ->where('producto.eliminado', 'NO')
            ->where('marca.activo', 1)
            ->where('categoria.activo', 1)
            ->orderBy('producto.precio', 'ASC')
            ->findAll();

        $this->mostrarProductosBuscados($data);
    }

    public function listarProductos(){
        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $this->mostrarVistaProductos($data, 'plantillas/productos');
    }

    private function mostrarVistaProductos($data, $vista){
        $data['titulo'] = 'NetShop | Productos';

        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view($vista, $data);
        echo view('plantillas/footer', $data);
    }

    public function buscarPorRangoPrecioProductos(){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();

        if (is_numeric($precioMin) && is_numeric($precioMax)) {
            $data['productos'] = $productoModel
                ->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                ->join('marca', 'marca.id_marca = producto.id_marca')
                ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                ->where('producto.precio >=', $precioMin)
                ->where('producto.precio <=', $precioMax)
                ->where('producto.eliminado', 'NO')
                ->where('marca.activo', 1)
                ->where('categoria.activo', 1)
                ->findAll();
        } else {
            $data['productos'] = [];
        }

        $this->mostrarVistaProductos($data, 'plantillas/productosPrecio');
    }

    public function ordenarProductosPorMayorPrecioProductos(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel
            ->getProductosConMarcaYCategoriaQuery()
            ->orderBy('producto.precio', 'DESC')
            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosOrdenados');
    }

    public function ordenarProductosPorMenorPrecioProductos(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel
            ->getProductosConMarcaYCategoriaQuery()
            ->orderBy('producto.precio', 'ASC')
            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosOrdenados');
    }

    public function listarProductosPorMarca($id){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($id);
        $productosModel = new Producto_model();
        $data['productos'] = $productosModel->getProductosConMarcaYCategoria();

        $this->mostrarVistaProductos($data, 'plantillas/productosMarca');
    }

    public function buscarPorRangoPrecioMarca($idMarca){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($idMarca); 
        $productoModel = new Producto_model();

        if (is_numeric($precioMin) && is_numeric($precioMax)) {
            $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                                ->join('marca', 'marca.id_marca = producto.id_marca')
                                                ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                                ->where('producto.id_marca', $idMarca)
                                                ->where('producto.precio >=', $precioMin)
                                                ->where('producto.precio <=', $precioMax)
                                                ->where('producto.eliminado', 'NO')
                                                ->where('marca.activo', 1)
                                                ->where('categoria.activo', 1)
                                                ->findAll();
        } else {
            $data['productos'] = [];
        }

        $this->mostrarVistaProductos($data, 'plantillas/productosMarca');
    }

    public function ordenarProductosPorMayorPrecioMarca($idMarca){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($idMarca);

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                            ->join('marca', 'marca.id_marca = producto.id_marca')
                                            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                            ->where('producto.id_marca', $idMarca)
                                            ->where('producto.eliminado', 'NO')
                                            ->where('marca.activo', 1)
                                            ->where('categoria.activo', 1)
                                            ->orderBy('producto.precio', 'DESC')
                                            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosMarca');
    }

    public function ordenarProductosPorMenorPrecioMarca($idMarca){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($idMarca);

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                            ->join('marca', 'marca.id_marca = producto.id_marca')
                                            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                            ->where('producto.id_marca', $idMarca)
                                            ->where('producto.eliminado', 'NO')
                                            ->where('marca.activo', 1)
                                            ->where('categoria.activo', 1)
                                            ->orderBy('producto.precio', 'ASC')
                                            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosMarca');
    }

    public function listarProductosPorCategoria($id){
        $productoModel = new Producto_model();
        $dato['productosTotal'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $categoriaModel = new Categoria_model();
        $dato['categoria'] = $categoriaModel->find($id);
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();
        $productosModel = new Producto_model();
        $dato['productos'] = $productosModel->getProductosConMarcaYCategoria();

        $data['titulo'] = 'NetShop | Productos';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/productosCategoria', $dato);
        echo view('plantillas/footer', $dato);
    }

    public function buscarPorRangoPrecioCategoria($idCategoria){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();
        $productoModel = new Producto_model();

        if (is_numeric($precioMin) && is_numeric($precioMax)) {
            $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                                ->join('marca', 'marca.id_marca = producto.id_marca')
                                                ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                                ->where('producto.id_categoria', $idCategoria)
                                                ->where('producto.precio >=', $precioMin)
                                                ->where('producto.precio <=', $precioMax)
                                                ->where('producto.eliminado', 'NO')
                                                ->where('marca.activo', 1)
                                                ->where('categoria.activo', 1)
                                                ->findAll();
        } else {
            $data['productos'] = [];
        }

        $this->mostrarVistaProductos($data, 'plantillas/productosCategoria');
    }

    public function ordenarProductosPorMayorPrecioCategoria($idCategoria){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                            ->join('marca', 'marca.id_marca = producto.id_marca')
                                            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                            ->where('producto.id_categoria', $idCategoria)
                                            ->where('producto.eliminado', 'NO')
                                            ->where('marca.activo', 1)
                                            ->where('categoria.activo', 1)
                                            ->orderBy('producto.precio', 'DESC')
                                            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosCategoria');
    }

    public function ordenarProductosPorMenorPrecioCategoria($idCategoria){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                                            ->join('marca', 'marca.id_marca = producto.id_marca')
                                            ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                                            ->where('producto.id_categoria', $idCategoria)
                                            ->where('producto.eliminado', 'NO')
                                            ->where('marca.activo', 1)
                                            ->where('categoria.activo', 1)
                                            ->orderBy('producto.precio', 'ASC')
                                            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosCategoria');
    }

    public function ayuda(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Ayuda';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/ayuda');
        echo view('plantillas/footer', $dato);
    }

    public function carrito(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $cart = \Config\Services::cart();
        $dato['cart'] = $cart;

        $metodoModel = new MetodoPago_model();
        $dato['metodosPago'] = $metodoModel->getMetodosPagoActivos();

        $data['titulo'] = 'NetShop | Carrito';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/carrito', $dato);
        echo view('plantillas/footer', $dato);
    }

    public function contacto(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Contacto';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/contacto');
        echo view('plantillas/footer', $dato);
    }

    public function consultas(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Consultas';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/consultas');
        echo view('plantillas/footer', $dato);
    }

    public function quienesSomos(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Quienes Somos';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/quienesSomos');
        echo view('plantillas/footer', $dato);
    }

    public function comercializacion(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Comercializacion';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/comercializacion');
        echo view('plantillas/footer', $dato);
    }

    public function terminosUsos(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();

        $data['titulo'] = 'NetShop | Terminos y Uso';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/terminosUsos');
        echo view('plantillas/footer', $dato);
    }
}
