<?php
namespace App\Models;
use CodeIgniter\Model;

class Producto_model extends Model{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre', 'imagen', 'id_categoria', 'precio', 'precio_vta', 'stock', 'stock_min', 'eliminado', 'descripcion', 'id_marca', 'id_proveedor'];

    public function verificarProductos(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->paginate(7);
    }

    public function getProductosActivados(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'NO')->paginate(7);
    }

    public function getProductosDesactivados(){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'SI')->paginate(7);
    }

    public function buscarProductosAll($query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->paginate(7);
        }
        return [];
    }

    public function buscarProductosActivos($query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'NO')
                        ->paginate(7);
        }
        return [];
    }

    public function buscarProductosDesactivados($query){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'SI')
                        ->paginate(7);
        }
        return [];
    }

    public function getProductosConMarcaYCategoria(){
        return $this->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria')
                    ->join('marca', 'marca.id_marca = producto.id_marca')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->findAll();
    }

    public function getProductosConMarcaYCategoriaQuery(){
        return $this->select('producto.*, marca.activo as activo_marca, categoria.activo as activo_categoria, categoria.descripcion as categoria_descripcion')
                    ->join('marca', 'marca.id_marca = producto.id_marca')
                    ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                    ->where('producto.eliminado', 'NO')
                    ->where('marca.activo', 1)
                    ->where('categoria.activo', 1);
    }

    public function validarStock($idProducto, $cantidad) {
        $producto = $this->buscarProductoPorId($idProducto);
        return $producto && $producto['stock'] >= $cantidad;
    }

    public function buscarProductoPorId($idProducto){
        return $this->find($idProducto); 
    }

    public function actualizarStockProducto ($idProducto, $nuevoStock){
        return $this->update($idProducto, ['stock' => $nuevoStock]);
    }
}