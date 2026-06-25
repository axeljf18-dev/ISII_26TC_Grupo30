<?php
namespace App\Controllers;
// namespace App\Services;
use CodeIgniter\Controller; 
use App\Models\Producto_model;
use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\Usuarios_model;
use App\Models\MetodoPago_model;
// use Config\Services;

class Carrito_controller extends BaseController{
    public function __construct(){
        helper(['url', 'form', 'cart']);
        $session = session();
        $cart = \Config\Services::cart();
        $cart->contents();
    }

    // AGREGAR PRODUCTO AL CARRITO
    public function add(int $id = null){
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

    // ACTUALIZAR CARRITO
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

    // DEVOLVER CARRITO 
    public function devolverCarrito(){
        $cart = \Config\Services::cart(); 
        return $cart->contents();
    }

    // SUMAR CANTIDAD DE PRODUCTOS EN EL CARRITO
    public function suma(string $rowid){
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

    // RESTAR CANTIDAD DE PRODUCTOS EN EL CARRITO
    public function resta(string $rowid){
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

    // ELIMINAR PRODUCTO DEL CARRITO
    public function eliminarProducto(string $rowid){
        $cart = \Config\Services::cart();
        $cart->remove($rowid);

        return redirect()->to('/carrito');
    }

    // ELIMINAR CARRITO COMPLETO
    public function eliminarCarrito(){
        $cart = \Config\Services::cart();
        $cart->destroy();

        return redirect()->to('/carrito');
    }

    // MOSTRAR CARRITO
    public function mostrarCarrito(){
        $metodoModel = new MetodoPago_model();
        $data['metodosPago'] = $metodoModel->getMetodosPagoActivos();

        $cart = \Config\Services::cart();
        $data['cart'] = $cart;

        if (!$this->verificarCarrito()) {
            $data['mensaje'] = 'No hay productos en "Mi Carrito"';
        }

        $data['titulo'] = 'NetShop | Carrito';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $this->dato);
        echo view('plantillas/carrito', $data);
        echo view('plantillas/footer', $this->dato);
    }

    // VERIFICAR SI HAY PRODUCTOS EN EL CARRITO
    private function verificarCarrito(){
        $cart = \Config\Services::cart();
        return !empty($cart->contents()); // da true si hay productos y false si está vacío
    }
}