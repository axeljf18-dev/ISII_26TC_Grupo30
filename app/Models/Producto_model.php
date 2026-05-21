<?php
namespace App\Models;
use CodeIgniter\Model;

class Producto_model extends Model{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre', 'imagen', 'id_categoria', 'precio', 'precio_vta', 'stock', 'stock_min', 'eliminado', 'descripcion', 'id_marca', 'id_proveedor'];

    public function getProductoAll(){
    return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                ->findAll();
    }

    public function buscarProductosActivos($query, $perPage = 7){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'NO')
                        ->paginate($perPage);
        }
        return [];
    }

    public function buscarProductosDesactivados($query, $perPage = 7){
        if($query){
            return $this->select('producto.*, categoria.descripcion as categoria_descripcion')
                        ->join('categoria', 'categoria.id_categoria = producto.id_categoria')
                        ->like('producto.nombre', $query)
                        ->where('producto.eliminado', 'SI')
                        ->paginate($perPage);
        }
        return [];
    }

    public function getProductosPaginados($perPage = 7){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'NO')->paginate($perPage);
    }

    public function getProductosDesactivadosPaginados($perPage = 7){
        return $this->select('producto.*, categoria.descripcion as categoria_descripcion')->join('categoria', 'categoria.id_categoria = producto.id_categoria')->where('producto.eliminado', 'SI')->paginate($perPage);
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

    public function getProducto($id){
        return $this->find($id); 
    }

    public function updateStock($id, $nuevoStock){
        return $this->update($id, ['stock' => $nuevoStock]);
    }
}