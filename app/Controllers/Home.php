<?php

namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\MetodoPago_model;
use App\Models\Producto_model;
use CodeIgniter\CLI\Console;

class Home extends BaseController
{
    // Método para mostrar la página de inicio
    public function inicio(){
        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        
        $data['titulo'] = 'NetShop | Principal';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/carrusel');
        echo view('plantillas/index', $data);
        echo view('plantillas/footer', $data);
    }

    // Método para buscar y mostrar productos 
    public function buscador(){
        $session = session();
        $query = $this->request->getVar('query'); 
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método privado para buscar productos según la consulta
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

    // Método privado para mostrar la vista de productos buscados
    private function mostrarProductosBuscados($data){
        $data['titulo'] = 'NetShop | Productos';

        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view('plantillas/productosBuscados', $data);
        echo view('plantillas/footer', $data);
    }

    // Método para buscar productos por rango de precio en el buscador
    public function buscarPorRangoPrecioBuscador(string $valor){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para ordenar productos por mayor precio en el buscador
    public function ordenarProductosPorMayorPrecioBuscador(string $valor){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

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

    // Método para ordenar productos por menor precio en el buscador
    public function ordenarProductosPorMenorPrecioBuscador(string $valor){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas(); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

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

    // Método para listar todos los productos
    public function listarProductos(){
        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

        $this->mostrarVistaProductos($data, 'plantillas/productos');
    }

    // Método privado para mostrar la vista de productos
    private function mostrarVistaProductos($data, $vista){
        $data['titulo'] = 'NetShop | Productos';

        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $data);
        echo view($vista, $data);
        echo view('plantillas/footer', $data);
    }

    // Método para buscar productos por rango de precio en la vista de productos
    public function buscarPorRangoPrecioProductos(){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para ordenar productos por mayor precio en la vista de productos
    public function ordenarProductosPorMayorPrecioProductos(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel
            ->getProductosConMarcaYCategoriaQuery()
            ->orderBy('producto.precio', 'DESC')
            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosOrdenados');
    }

    // Método para ordenar productos por menor precio en la vista de productos
    public function ordenarProductosPorMenorPrecioProductos(){
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $productoModel = new Producto_model();

        $data['productos'] = $productoModel
            ->getProductosConMarcaYCategoriaQuery()
            ->orderBy('producto.precio', 'ASC')
            ->findAll();

        $this->mostrarVistaProductos($data, 'plantillas/productosOrdenados');
    }

    // Método para listar productos por marca
    public function listarProductosPorMarca(int $idMarca){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
        $marcaModel = new Marca_model();
        $data['marca'] = $marcaModel->find($idMarca);
        $productosModel = new Producto_model();
        $data['productos'] = $productosModel->getProductosConMarcaYCategoria();

        $this->mostrarVistaProductos($data, 'plantillas/productosMarca');
    }

    // Método para buscar productos por rango de precio en la vista de productos por marca
    public function buscarPorRangoPrecioMarca(int $idMarca){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');  
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para ordenar productos por mayor precio en la vista de productos por marca
    public function ordenarProductosPorMayorPrecioMarca(int $idMarca){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para ordenar productos por menor precio en la vista de productos por marca
    public function ordenarProductosPorMenorPrecioMarca(int $idMarca){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para listar productos por categoría
    public function listarProductosPorCategoria(int $idCategoria){
        $productoModel = new Producto_model();
        $dato['productosTotal'] = $productoModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $categoriaModel = new Categoria_model();
        $dato['categoria'] = $categoriaModel->find($idCategoria);
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();
        $productosModel = new Producto_model();
        $dato['productos'] = $productosModel->getProductosConMarcaYCategoria();

        $data['titulo'] = 'NetShop | Productos';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/productosCategoria', $dato);
        echo view('plantillas/footer', $dato);
    }

    // Método para buscar productos por rango de precio en la vista de productos por categoría
    public function buscarPorRangoPrecioCategoria(int $idCategoria){
        $precioMin = $this->request->getVar('precioMin');
        $precioMax = $this->request->getVar('precioMax');
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();
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

    // Método para ordenar productos por mayor precio en la vista de productos por categoría
    public function ordenarProductosPorMayorPrecioCategoria(int $idCategoria){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

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

    // Método para ordenar productos por menor precio en la vista de productos por categoría
    public function ordenarProductosPorMenorPrecioCategoria(int $idCategoria){
        $productosModel = new Producto_model();
        $data['productosTotal'] = $productosModel->getProductosConMarcaYCategoria();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $categoriaModel = new Categoria_model();
        $data['categoria'] = $categoriaModel->find($idCategoria); 
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

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

    // Método para mostrar la página de ayuda
    public function ayuda(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Ayuda';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/ayuda');
        echo view('plantillas/footer', $dato);
    }

    // Método para mostrar la página de contacto
    public function contacto(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Contacto';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/contacto');
        echo view('plantillas/footer', $dato);
    }

    // Método para mostrar la página de consultas
    public function consultas(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Consultas';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/consultas');
        echo view('plantillas/footer', $dato);
    }

    // Método para mostrar la página de quienes somos
    public function quienesSomos(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Quienes Somos';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/quienesSomos');
        echo view('plantillas/footer', $dato);
    }

    // Método para mostrar la página de comercialización
    public function comercializacion(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Comercializacion';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/comercializacion');
        echo view('plantillas/footer', $dato);
    }

    // Método para mostrar la página de términos y usos
    public function terminosUsos(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();

        $data['titulo'] = 'NetShop | Terminos y Uso';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('plantillas/terminosUsos');
        echo view('plantillas/footer', $dato);
    }
}
