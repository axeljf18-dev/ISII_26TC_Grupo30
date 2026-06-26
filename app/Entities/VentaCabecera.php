<?php
namespace App\Entities;

use DateTime;

class VentaCabecera {
    // Atributos principales
    private int $idVentaCabecera;
    private DateTime $fecha;
    private float $totalVenta;
    private int $idUsuario;
    private int $idMetodoPago;
    private array $productos;

    // Constructor: inicializa la venta
    public function __construct(array $productos, int $idMetodoPago, float $totalVenta, int $idUsuario) {
        $this->productos = $productos;
        $this->idMetodoPago = $idMetodoPago;
        $this->totalVenta = $totalVenta;
        $this->idUsuario = $idUsuario;
        $this->fecha = new DateTime();
    }

    // Métodos de acceso para obtener los datos de la venta
    public function getId() { 
        return $this->idVentaCabecera ?? null; 
    }
    public function getFecha() {
        return $this->fecha; 
    }
    public function getTotal() { 
        return $this->totalVenta; 
    }
    public function getUsuarioId() { 
        return $this->idUsuario; 
    }
    public function getMetodoPago() { 
        return $this->idMetodoPago; 
    }
    public function getProductos() { 
        return $this->productos; 
    }
}