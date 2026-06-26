<?php

use App\Controllers\Producto_controller;
use CodeIgniter\HTTP\Files\UploadedFile;
use PHPUnit\Framework\TestCase;
use CodeIgniter\HTTP\IncomingRequest;
use Config\App;
use CodeIgniter\HTTP\URI;
use CodeIgniter\HTTP\UserAgent;
use CodeIgniter\Test\TestRequest;
use Config\Services;

class ValidarDatosProductoTest extends TestCase {
    public function testNombreVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(
            __DIR__ . '/fake.jpg', // ruta a un archivo dummy en tu carpeta de tests
            'fake.jpg',
            'image/jpeg',
            1234, 
            UPLOAD_ERR_OK
        );
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => '', // nombre vacío
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorNombre = $validation->getError('nombre');

        // Mostrar el mensaje
        var_dump($errorNombre);

        // Aserción
        $this->assertEquals('El campo nombre es obligatorio.', $errorNombre);
    }

    public function testNombreCorto() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'A', // nombre corto
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorNombre = $validation->getError('nombre');

        // Mostrar el mensaje
        var_dump($errorNombre);

        // Aserción
        $this->assertEquals('El campo nombre debe tener al menos 2 caracteres de longitud.', $errorNombre);
    }

    public function testNombreLargo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => str_repeat('X', 60), // nombre largo
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorNombre = $validation->getError('nombre');

        // Mostrar el mensaje
        var_dump($errorNombre);

        // Aserción
        $this->assertEquals('El campo nombre no pude exceder los 50 caracteres de longitud.', $errorNombre);
    }

    public function testPrecioVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => '', // precio vacío
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecio = $validation->getError('precio');

        // Mostrar el mensaje
        var_dump($errorPrecio);

        // Aserción
        $this->assertEquals('El campo precio es obligatorio.', $errorPrecio);
    }

    public function testPrecioNegativo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => -893050, // precio negativo
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecio = $validation->getError('precio');

        // Mostrar el mensaje
        var_dump($errorPrecio);

        // Aserción
        $this->assertEquals('El campo precio debe contener un número mayor que 0.', $errorPrecio);
    }

    public function testPrecioCero() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 0, // precio cero
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecio = $validation->getError('precio');

        // Mostrar el mensaje
        var_dump($errorPrecio);

        // Aserción
        $this->assertEquals('El campo precio debe contener un número mayor que 0.', $errorPrecio);
    }

    public function testPrecioVtaVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => '', // precio venta vacío
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecioVta = $validation->getError('precioVta');

        // Mostrar el mensaje
        var_dump($errorPrecioVta);

        // Aserción
        $this->assertEquals('El campo precioVta es obligatorio.', $errorPrecioVta);
    }

    public function testPrecioVtaNegativo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050, 
            'precioVta' => -700405, // precio negativo
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecioVta = $validation->getError('precioVta');

        // Mostrar el mensaje
        var_dump($errorPrecioVta);

        // Aserción
        $this->assertEquals('El campo precioVta debe contener un número mayor que 0.', $errorPrecioVta);
    }

    public function testPrecioVtaCero() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050, 
            'precioVta' => 0, // precio venta cero
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorPrecioVta = $validation->getError('precioVta');

        // Mostrar el mensaje
        var_dump($errorPrecioVta);

        // Aserción
        $this->assertEquals('El campo precioVta debe contener un número mayor que 0.', $errorPrecioVta);
    }

    public function testStockVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => '', // stock vacío
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorStock = $validation->getError('stock');

        // Mostrar el mensaje
        var_dump($errorStock);

        // Aserción
        $this->assertEquals('El campo stock es obligatorio.', $errorStock);
    }

    public function testStockNegativo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => -10, // stock negativo
            'stockMin' => 3,
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorStock = $validation->getError('stock');

        // Mostrar el mensaje
        var_dump($errorStock);

        // Aserción
        $this->assertEquals('El campo stock debe contener solo dígitos.', $errorStock);
    }

    public function testImagenNoSubida() {
        $request = \Config\Services::request();
        // Simular archivo no subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_NO_FILE);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,  
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorImagen = $validation->getError('imagen');

        // Mostrar el mensaje
        var_dump($errorImagen);

        // Aserción
        $this->assertEquals('imagen no es un campo de subida de archivo válido.', $errorImagen);
    }

    public function testImagenExcedeTamanoMaximo() {
        $request = \Config\Services::request();
        // Simular archivo subido con tamaño mayor a 8 MB
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 9 * 1024 * 1024, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,  
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorImagen = $validation->getError('imagen');

        // Mostrar el mensaje
        var_dump($errorImagen);

        // Aserción
        $this->assertEquals('imagen no es un campo de subida de archivo válido.', $errorImagen);
    }

    public function testImagenExtensionInvalida() {
        $request = \Config\Services::request();
        // Simular archivo subido con extensión GIF
        $file = new UploadedFile(__DIR__ . '/fake.gif', 'fake.gif', 'image/gif', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,  
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorImagen = $validation->getError('imagen');

        // Mostrar el mensaje
        var_dump($errorImagen);

        // Aserción
        $this->assertEquals('imagen no es un campo de subida de archivo válido.', $errorImagen);
    }

    public function testStockMinVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '', // stock minimo vacío
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorStockMin = $validation->getError('stockMin');

        // Mostrar el mensaje
        var_dump($errorStockMin);

        // Aserción
        $this->assertEquals('El campo stockMin es obligatorio.', $errorStockMin);
    }

    public function testStockMinNegativo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => -3, // stock negativo
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorStockMin = $validation->getError('stockMin');

        // Mostrar el mensaje
        var_dump($errorStockMin);

        // Aserción
        $this->assertEquals('El campo stockMin debe contener solo dígitos.', $errorStockMin);
    }

    public function testDescripcionVacio() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> '', // descripcion vacío
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorDescripcion = $validation->getError('descripcion');

        // echo "Mensaje de error en descripción: " . ($errorDescripcion ?: "Sin errores, campo válido") . PHP_EOL;

        // Ya que permite texto vacio, no debe haber error
        $this->assertEmpty($errorDescripcion);
    }

    public function testDescripcionCorto() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> 'A', // descripcion corto
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorDescripcion = $validation->getError('descripcion');

        // Mostrar el mensaje
        var_dump($errorDescripcion);

        // Aserción
        $this->assertEquals('El campo descripcion debe tener al menos 5 caracteres de longitud.', $errorDescripcion);
    }

    public function testDescripcionLargo() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro', 
            'precio' => 893050,
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => 3,
            'descripcion'=> str_repeat('X', 300), // descripcion largo
            'categoria' => 1,
            'marca' => 1,
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorDescripcion = $validation->getError('descripcion');

        // Mostrar el mensaje
        var_dump($errorDescripcion);

        // Aserción
        $this->assertEquals('El campo descripcion no pude exceder los 255 caracteres de longitud.', $errorDescripcion);
    }

    public function testMarcaNoSeleccionada() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => '',  // marca no seleccionada
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorMarca = $validation->getError('marca');

        // Mostrar el mensaje
        var_dump($errorMarca);

        // Aserción
        $this->assertEquals('El campo marca es obligatorio.', $errorMarca);
    }

    public function testCategoriaNoSeleccionada() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => '', // categoria no seleccionada
            'marca' => 1,  
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorCategoria = $validation->getError('categoria');

        // Mostrar el mensaje
        var_dump($errorCategoria);

        // Aserción
        $this->assertEquals('El campo categoria es obligatorio.', $errorCategoria);
    }

    public function testProveedorNoSeleccionada() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,  
            'proveedor' => '', // proveedor no seleccionada
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);
        $errorProveedor = $validation->getError('proveedor');

        // Mostrar el mensaje
        var_dump($errorProveedor);

        // Aserción
        $this->assertEquals('El campo proveedor es obligatorio.', $errorProveedor);
    }

    public function testTodosLosCamposVacios() {
        $request = \Config\Services::request();
        // Simular archivo no subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_NO_FILE);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => '', // nombre vacio
            'precio' => '',  // precio vacio
            'precioVta' => '', // precio venta vacio
            'stock' => '', // stock  vacio
            'stockMin' => '', // stock minimo vacio
            'descripcion'=> '', // descripcion vacio
            'categoria' => '', // categoria no seleccionada
            'marca' => '',  // marca no seleccionada
            'proveedor' => '', // proveedor no seleccionada
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);

        // Mostrar mensajes
        var_dump($validation->getError('nombre'));
        var_dump($validation->getError('precio'));
        var_dump($validation->getError('precioVta'));
        var_dump($validation->getError('stock'));
        var_dump($validation->getError('imagen'));
        var_dump($validation->getError('categoria'));
        var_dump($validation->getError('marca'));
        var_dump($validation->getError('proveedor'));

        // Aserción
        $this->assertEquals('El campo nombre es obligatorio.', $validation->getError('nombre'));
        $this->assertEquals('El campo precio es obligatorio.', $validation->getError('precio'));
        $this->assertEquals('El campo precioVta es obligatorio.', $validation->getError('precioVta'));
        $this->assertEquals('El campo stock es obligatorio.', $validation->getError('stock'));
        $this->assertEquals('El campo stockMin es obligatorio.', $validation->getError('stockMin'));
        $this->assertEquals('imagen no es un campo de subida de archivo válido.', $validation->getError('imagen'));
        $this->assertEquals('El campo categoria es obligatorio.', $validation->getError('categoria'));
        $this->assertEquals('El campo marca es obligatorio.', $validation->getError('marca'));
        $this->assertEquals('El campo proveedor es obligatorio.', $validation->getError('proveedor'));
        $this->assertEmpty($validation->getError('descripcion')); // Esto es opcional
    }

    public function testTodosLosCamposCompletos() {
        $request = \Config\Services::request();
        // Simular archivo subido
        $file = new UploadedFile(__DIR__ . '/fake.jpg', 'fake.jpg', 'image/jpeg', 1234, UPLOAD_ERR_OK);
        $request->setGlobal('files', ['imagen' => $file]);

        // Definir reglas
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules([
            'nombre' => 'required|trim|min_length[2]|max_length[50]',
            'precio' => 'required|numeric|greater_than[0]',
            'precioVta' => 'required|numeric|greater_than[0]',
            'stock' => 'required|is_natural',
            'stockMin' => 'required|is_natural',
            'imagen' => 'uploaded[imagen]|max_size[imagen,8192]|ext_in[imagen,png,jpg,jpeg]',
            'descripcion'=> 'permit_empty|trim|min_length[5]|max_length[255]',
            'categoria' => 'required',
            'marca' => 'required',
            'proveedor' => 'required'
        ]);

        // Datos del formulario
        $data = [
            'nombre' => 'Notebook Apple MacBook Pro',
            'precio' => 893050, 
            'precioVta' => 700405,
            'stock' => 10,
            'stockMin' => '3',
            'descripcion'=> 'Pantalla Liquid Retina XDR Full HD',
            'categoria' => 1,
            'marca' => 1,  
            'proveedor' => 1,
        ];

        // Ejecutar validación con el request
        $validation->withRequest($request)->run($data);

        // Aserción
        $this->assertEmpty($validation->getError('nombre'));
        $this->assertEmpty($validation->getError('precio'));
        $this->assertEmpty($validation->getError('precioVta'));
        $this->assertEmpty($validation->getError('stock'));
        $this->assertEmpty($validation->getError('stockMin'));
        $this->assertEmpty($validation->getError('descripcion'));
        $this->assertEmpty($validation->getError('categoria'));
        $this->assertEmpty($validation->getError('marca'));
        $this->assertEmpty($validation->getError('proveedor'));
    }
}