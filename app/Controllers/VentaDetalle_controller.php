<?php
namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Marca_model;
use App\Models\Producto_model;
use App\Models\Usuarios_model;
use App\Models\VentaCabecera_model;
use App\Models\VentaDetalle_model;
use CodeIgniter\Controller;

class VentaDetalle_controller extends Controller{
    public function index(){
        helper(['form', 'url']);
    }

    // public function verFactura($ventaId){
    //     $categoriaModel = new Categoria_model();
    //     $data['categorias'] = $categoriaModel->getCategoriaAll();
    //     $detalleVentasModel = new VentaDetalle_model();
    //     $data['ventas'] = $detalleVentasModel->getDetalles($ventaId);
    //     // $productoModel = new Producto_model();
    //     // $data['productos'] = $productoModel->getProductoAll();
    //     $marcaModel = new Marca_model();
    //     $data['marcas'] = $marcaModel->getMarcaAll();

    //     $dato['titulo'] = "NetShop | Detalles";
    //     echo view('plantillas/header', $dato);
    //     echo view('plantillas/nav', $data);
    //     echo view('plantillas/detalleDeCompra', $data);
    //     echo view('plantillas/footer', $data);
    // }

    // public function indexDetalleCompra($ventaIdCliente){
    //     $ventasCabeceraModel = new VentaCabecera_model();
    //     $ventaGeneral = $ventasCabeceraModel->find($ventaIdCliente);
    //     $data['venta_general'] = $ventaGeneral;
    //     $usuarioModel = new Usuarios_model();
    //     $data['usuario'] = $usuarioModel->find($ventaGeneral['id_usuario']);
    //     $detalleVentasModel = new VentaDetalle_model();
    //     $data['detalles'] = $detalleVentasModel->getDetalles($ventaIdCliente);
    //     $productoModel = new Producto_model();
    //     $data['productos'] = $productoModel->getProductoAll();

    //     $dato['titulo'] = "Dashboard | Detalles";
    //     echo view('plantillas/header', $dato);
    //     echo view('plantillas/nav');
    //     echo view('back/admin/detallesVentas', $data);
    //     echo view('plantillas/footer');
    // }

    public function mostrarDetalleVenta($ventaId){
        $ventasCabeceraModel = new VentaCabecera_model();
        $ventaGeneral = $ventasCabeceraModel->find($ventaId);
        $data['venta_general'] = $ventaGeneral;
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($ventaGeneral['id_usuario']);
        $detalleVentasModel = new VentaDetalle_model();
        $data['detalles'] = $detalleVentasModel->getDetalles($ventaId);
        $detalleVentasModel = new VentaDetalle_model();
        $data['ventas'] = $detalleVentasModel->getDetalles($ventaId);
        $productoModel = new Producto_model();
        $data['productos'] = $productoModel->getProductoAll();
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcaAll();

        $dato['titulo'] = "NetShop | Detalles";
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav', $data);
        if(session()->get('rol') === 'admin'){
            echo view('back/admin/detallesVentas', $data);
        } else {
            echo view('plantillas/detalleDeCompra', $data);
        }
        echo view('plantillas/footer', $data);
    }
}