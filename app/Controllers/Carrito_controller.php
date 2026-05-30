<?php
namespace App\Controllers;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Usuarios_model;
use App\Models\MetodoPago_model;

class Carrito_controller extends Controller{
    public function __construct(){
        helper(['url', 'form', 'cart']);
        $session = session();
        $cart = \Config\Services::cart();
        $cart->contents();
    }

    public function add($id = null){
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();

        $producto = new Producto_model();
        $producto = $producto->where('id_producto', $id)->first();

        $cart->insert([
            'id'        => $producto['id_producto'],
            'qty'       => 1,
            'name'      => $producto['nombre'],
            'price'     => $producto['precio_vta'],
            'imagen'    => $producto['imagen'],
            'options' => [
                'descripcion' => $producto['descripcion'],
            ]
        ]);

        return redirect()->back()->withInput();
    }

    public function update(){
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();

        $cart->update([
            'id'        => $request->getPost('id'),
            'qty'       => 1,
            'name'      => $request->getPost('nombre'),
            'price'     => $request->getPost('precio_vta'),
            'imagen'    => $request->getPost('imagen'),
        ]);

        return redirect()->back()->withInput();
    }

    public function devolverCarrito(){
        $cart = \Config\Services::cart(); 
        return $cart->contents();
    }


    public function suma($rowid){
        $cart = \Config\Services::cart();
        $item = $cart->getItem($rowid);
        if($item){
            $cart->update([
                'rowid' => $rowid,
                'qty' => $item['qty'] + 1,
            ]);
        }
        return redirect()->to('/carrito');
    }

    public function resta($rowid){
        $cart = \Config\Services::cart();
        $item = $cart->getItem($rowid);
        if($item){
            if ($item['qty'] > 1) {
                $cart->update([
                    'rowid' => $rowid,
                    'qty' => $item['qty'] - 1,
                ]);
            } else {
                $cart->remove($rowid);
            }
        }
        return redirect()->to('/carrito');
    }

    public function eliminarProducto($rowid){
        $cart = \Config\Services::cart();
        $cart->remove($rowid);

        return redirect()->to('/carrito');
    }

    public function eliminarCarrito(){
        $cart = \Config\Services::cart();
        $cart->destroy();

        return redirect()->to('/carrito');
    }
}