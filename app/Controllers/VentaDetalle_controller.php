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

    // MOSTRAR DETALLE DE VENTA
    public function mostrarDetalleVenta(int $idVenta){
        $ventasCabeceraModel = new VentaCabecera_model();
        $ventaGeneral = $ventasCabeceraModel->find($idVenta);
        $data['venta_general'] = $ventaGeneral;
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($ventaGeneral['id_usuario']);
        $detalleVentasModel = new VentaDetalle_model();
        $data['detalles'] = $detalleVentasModel->getBuscarDetalles($idVenta);
        $detalleVentasModel = new VentaDetalle_model();
        $data['ventas'] = $detalleVentasModel->getBuscarDetalles($idVenta);
        $categoriaModel = new Categoria_model();
        $data['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $data['marcas'] = $marcaModel->getMarcasActivas();

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