<main class="conteiner__detallesCompra">
    <div class="bg-light pb-3 pt-2 ps-2 pe-2">
        <h1 class="text-center bg-light mb-3 pt-2">Detalle de la Compra</h1>
        <div class="text-end">
            <button id="btnImprimir" class="p-2 border-0 rounded-2"><b class="text-white bg-opacity-75">Imprimir Detalle</b></button>
        </div>
        <?php if(session()->getFlashdata('mensajeVenta')): ?>
            <div class="text-center mt-2">
                <p class="fs-5 text-white"><b class="p-1 bg-success bg-opacity-75 rounded-2"><?= session()->getFlashdata('mensajeVenta'); ?></b></p>
            </div>
        <?php endif; ?>
        <div class="contenedor__tablaDetallesCompra mt-2">        
            <table class="table table-bordered shadow">
                <thead>
                    <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $acumulado = 0;     
                    foreach($ventas as $venta): 
                        $subtotal = $venta['cantidad'] * $venta['precio'];
                        $acumulado += $subtotal;
                        foreach($productos as $producto): 
                    ?>
                    <tr>
                        <?php if($venta['id_producto'] == $producto['id_producto']): ?>
                            <td class="text-center"><?= esc($producto['nombre']) ?></td>
                            <td class="text-center"><?= esc($producto['descripcion']) ?></td>
                            <td class="text-center"><?= esc($venta['cantidad']) ?></td>
                            <td class="text-center">$<?= number_format($venta['precio'], 2) ?></td>
                            <td class="text-center">$<?= number_format($subtotal, 2) ?></td>
                        <?php endif; ?>
                    </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total</strong></td>
                        <td class="text-center"><strong>$<?= number_format($acumulado, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Imprimir -->
<script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("btnImprimir").addEventListener("click", function(){
            imprimirDetalle();
        });
    });

    function imprimirDetalle() {
        var contenido = document.querySelector(".contenedor__tablaDetallesCompra").innerHTML;
        var ventana = window.open('', '', 'height=800,width=800');
        ventana.document.write('<html><head><title>Detalle de la Compra</title>');
        ventana.document.write('<style>');
        ventana.document.write('body { display: flex; justify-content: center; align-items: center; height: 95%; flex-direction: column; text-align: center; background: #f8f9fa; padding: 20px; }');
        ventana.document.write('table { border-collapse: collapse; width: 90%; margin: 0 auto; }'); 
        ventana.document.write('th, td { border: 2px solid black; padding: 8px; text-align: center; }'); 
        ventana.document.write('h2 { margin-bottom: 20px; }'); 
        ventana.document.write('</style></head><body>');
        ventana.document.write('<h2>Detalle de la Compra</h2>');
        ventana.document.write(contenido);
        ventana.document.write('</body></html>');
        ventana.document.close();
        ventana.print();
    }
</script>