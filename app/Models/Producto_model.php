<?php
namespace App\Models;
use CodeIgniter\Model;

class Producto_model extends Model{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre', 'imagen', 'id_categoria', 'precio', 'precio_vta', 'stock', 'stock_min', 'eliminado', 'descripcion', 'id_marca', 'id_proveedor'];

    // Método para obtener todos los productos con su categoría
    public function verificarProductos(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->paginate(7);
    }

    // Método para obtener todos los productos activados
    public function getProductosActivados(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'NO')->paginate(7);
    }

    // Método para obtener todos los productos desactivados
    public function getProductosDesactivados(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'SI')->paginate(7);
    }

    // Método para buscar productos por nombre
    public function buscarProductosAll(string $query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->paginate(7);
        }
        return [];
    }

    // Método para buscar productos activos por nombre
    public function buscarProductosActivos(string $query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'NO')
                        ->paginate(7);
        }
        return [];
    }

    // Método para buscar productos desactivados por nombre
    public function buscarProductosDesactivados(string $query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'SI')
                        ->paginate(7);
        }
        return [];
    }

    // Método para obtener todos los productos con su marca y categoría
    public function getProductosConMarcaYCategoria(){
        return $this->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria')
                    ->join('marca', 'marca.id_marca = producto.id_marca')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->findAll();
    }

    // Método para obtener todos los productos con su marca y categoría, filtrando por activos
    public function getProductosConMarcaYCategoriaQuery(){
        return $this->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                    ->join('marca', 'marca.id_marca = producto.id_marca')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->where('producto.eliminado', 'NO')
                    ->where('marca.activo', 1)
                    ->where('categoria.activo', 1);
    }

    // Método para validar si hay suficiente stock de un producto
    public function validarStock(int $idProducto, int $cantidad) {
        $producto = $this->buscarProductoPorId($idProducto);
        return $producto && $producto['stock'] >= $cantidad;
    }

    // Método para buscar un producto por su ID
    public function buscarProductoPorId(int $idProducto){
        return $this->find($idProducto); 
    }

    // Método para actualizar el stock de un producto
    public function actualizarStockProducto (int $idProducto, int $nuevoStock){
        return $this->update($idProducto, ['stock' => $nuevoStock]);
    }
}