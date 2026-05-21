<main class="conteiner__listaDeVentaDetalleCompraRealizada">
    <div class="bg-white rounded-2">
        <h1 class="text-center pt-2">Detalle de la Compra</h1>
        <div class="text-end pb-2 pe-2">
            <button id="btnImprimir" class="p-2 border-0 rounded-2"><b class="text-white bg-opacity-75">Imprimir Detalle</b></button>
        </div>
        <div class="contenedor__tablaDetallesCompra listaDeVentaDetalleCompraRealizada-scroll mt-2 p-2">
            <div class="row w-100 ms-0 border-top">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end border-start d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Producto</b></p>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Descripción</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Cantidad</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                    <p class="mb-0"><b>Precio</b></p>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 text-center border-end">
                    <p class="mb-0"><b>Subtotal</b></p>
                </div>
            </div>
            <?php 
                $acumulado = 0;
            ?>        
            <?php foreach($detalles as $detalle): ?>
                <?php 
                    $productoEncontrado = null;
                    foreach($productos as $producto){
                        if($producto['id_producto'] == $detalle['id_producto']){
                            $productoEncontrado = $producto;
                            break;
                        }
                    }
                    $subtotal = $detalle['cantidad'] * $productoEncontrado['precio_vta'];
                    $acumulado += $subtotal;
                ?>
                <div class="row w-100 ms-0 border-top">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end border-start d-flex justify-content-center">
                        <p class="mb-0"><?= isset($productoEncontrado) ? esc($productoEncontrado['nombre']) : 'Producto no encontrado' ?></p>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><?= isset($productoEncontrado) ? esc($productoEncontrado['descripcion']) : '' ?></p>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center">
                        <p class="mb-0"><?= esc($detalle['cantidad']) ?></p>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 border-end d-flex justify-content-center">
                        <p class="mb-0">$<?= number_format($productoEncontrado['precio_vta'], 2) ?></p>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 pb-3 pt-3 text-center border-end">
                        <p class="mb-0">$<?= number_format($subtotal, 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="row w-100 ms-0 border-top border-bottom">
                <div class="col-10 pb-3 pt-3 border-end border-start d-flex justify-content-end align-items-center">
                    <p class="mb-0"><strong>Total</strong></p>
                </div>
                <div class="col-2 pb-3 pt-3 d-flex justify-content-center align-items-center">
                    <p class="mb-0"><strong>$<?= number_format($acumulado, 2) ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Imprimir -->
<script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("btnImprimir").addEventListener("click", imprimirDetalle);
    });

    function imprimirDetalle() {
        var tabla = document.querySelector(".contenedor__tablaDetallesCompra");
        if (!tabla) {
            alert("No se encontró el bloque de detalles");
            return;
        }
        var contenido = tabla.innerHTML;
        var ventana = window.open('', '', 'height=800,width=800');
        ventana.document.write(`
            <html>
                <head>
                    <title>Detalle de la Compra</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                    <style>
                        body { margin: 20px; background: #f8f9fa; }
                        table { border-collapse: collapse; width: 90%; margin: 0 auto; }
                        th, td { border: 2px solid black; padding: 8px; text-align: center; }
                    </style>
                </head>
                <body>
                    <h2 class="text-center mb-3 pt-2">Detalle de la Compra</h2>
                    ${contenido}
                </body>
            </html>
        `);
        ventana.document.close();
        ventana.focus();
        ventana.onload = function() {
            ventana.print();
            ventana.close();
        };
    }
</script>