<?php 
    $session = session();
    $boleano = empty($ventas);
    $valorFechaInicioQuery = $session->getFlashdata('fechaInicioQueryValor');
    $valorFechaFinQuery = $session->getFlashdata('fechaFinQueryValor');
    $valorFechasIncorrectasDeVentas = $session->getFlashdata('msgFechasIncorrectasDeVentas');
?>

<main class="conteiner__listaDeVentas">
    <?php if (empty($ventas) && !$boleano): ?>
        <div class="bg-white mt-5 pt-5 pb-5 border-top">
            <div class="text-center">
                <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registradas" width="140px">
            </div>
            <h4 class="text-center ps-4 pe-4"><b>No hay ventas registradas aún</b></h4>
        </div>
    <?php elseif (empty($ventas) && $boleano): ?>
        <div class="mb-1 d-flex justify-content-end">
            <form class="w-100" action="<?= base_url('enviar-formFechaQuery'); ?>" method="GET">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 text-center">
                        <p class="mb-0"><b>Buscar desde: </b></p>
                        <input type="date" name="fechaInicioQuery" value="<?= $valorFechaInicioQuery; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 text-center">
                        <p class="mb-0"><b>Buscar hasta: </b></p>
                        <input type="date" name="fechaFinQuery" value="<?= $valorFechaFinQuery; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <button class="w-25 mt-2 mb-3 p-2 border btn btn-primary"><b>Buscar</b></button>
                </div>
            </form>
        </div>
        <div class="bg-white rounded-2">
            <h1 class="text-center pt-2">Lista de Ventas</h1>
            <div class="d-flex justify-content-end pb-2 pe-2">
                <?php if (!empty($ventasPdf)) : ?>
                    <a href="#" id="btnImprimirVentas" class="btn btn-secondary text-white rounded-2">
                        <b>Generar PDF</b>
                    </a>
                <?php endif; ?>
            </div>
            <div class="listaDeVentas-scroll">
                <div class="row w-100 ms-0 border-top">
                    <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Titular</b></p>
                    </div>
                    <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Fecha (Tiempo)</b></p>
                    </div>
                    <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Total ($)</b></p>
                    </div>
                    <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Acciones</b></p>
                    </div>
                </div>
                <div class="bg-white pt-5 pb-5 border-top">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registradas" width="140px">
                    </div>
                    <h4 class="text-center ps-4 pe-4"><b>No se encontraron ventas en el rango seleccionado</b></h4>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="mb-1 d-flex justify-content-end">
            <form class="w-100" action="<?= base_url('enviar-formFechaQuery'); ?>" method="GET">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 text-center">
                        <p class="mb-0"><b>Buscar desde: </b></p>
                        <input type="date" name="fechaInicioQuery" value="<?= $valorFechaInicioQuery; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 text-center">
                        <p class="mb-0"><b>Buscar hasta: </b></p>
                        <input type="date" name="fechaFinQuery" value="<?= $valorFechaFinQuery; ?>" class="w-75 p-2 border shadow mx-auto d-block" onkeydown="return false">
                    </div>
                </div>
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <button class="w-25 mt-2 mb-3 p-2 border btn btn-primary"><b>Buscar</b></button>
                </div>
            </form>
        </div>
        <div class="bg-white rounded-2">
            <h1 class="text-center pt-2">Lista de Ventas</h1>
            <div class="d-flex justify-content-end pb-2 pe-2">
                <!-- <a href="#" id="btnImprimirVentas" class="btn btn-secondary text-white rounded-2"><b>Generar PDF</b></a> -->
                <?php if (!empty($ventasPdf)) : ?>
                    <a href="#" id="btnImprimirVentas" class="btn btn-secondary text-white rounded-2">
                        <b>Generar PDF</b>
                    </a>
                <?php endif; ?>
            </div>
            <div class="listaDeVentas-scroll">
                <div class="row w-100 ms-0 border-top">
                    <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Titular</b></p>
                    </div>
                    <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Fecha (Tiempo)</b></p>
                    </div>
                    <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Total ($)</b></p>
                    </div>
                    <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                        <p class="mb-0"><b>Acciones</b></p>
                    </div>
                </div>
                <?php if($boleano == true && $valorFechasIncorrectasDeVentas == false): ?>
                    <div class="bg-white pt-5 pb-5 border-top">
                        <div class="text-center">
                            <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registrada" width="140px">
                        </div>
                        <h4 class="text-center ps-4 pe-4"><b>No se encontraron ventas en el rango seleccionado</b></h4>
                    </div>
                <?php elseif($boleano == true && $valorFechasIncorrectasDeVentas == true): ?>
                    <div class="bg-white pt-5 pb-5 border-top">
                        <div class="text-center">
                            <img src="<?= base_url('assets/img/VentasNoRegistradas.png'); ?>" alt="Ventas no registrada" width="140px">
                        </div>
                        <h4 class="text-center ps-4 pe-4"><b>No se encontraron ventas en el rango seleccionado</b></h4>
                    </div>
                <?php else: ?>
                    <?php foreach($ventas as $venta): ?>
                        <div class="row w-100 ms-0 border-top">
                            <div class="col-4 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0"><?= $venta['usuario_nombre']; ?></p>
                            </div>
                            <div class="col-2 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <?php 
                                    $fechaObj = new DateTime($venta['fecha']);
                                    $soloFecha = $fechaObj->format('Y-m-d');
                                    $soloHora = $fechaObj->format('H:i:s');
                                ?>
                                <p class="mb-0"><?= $soloFecha ?> (<?= $soloHora ?>)</p>
                            </div>
                            <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <p class="mb-0">$<?= number_format($venta['total_venta'], 2); ?></p>
                            </div>
                            <div class="col-3 pb-3 pt-3 border-end d-flex justify-content-center align-items-center">
                                <a href="<?= base_url('mostrarDetalleCompraCliente/' . $venta['id_venta_cabecera']) ?>" class="btn btn-primary text-white">
                                    <b>Detalles</b>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if(isset($pager)): ?>
            <div class="d-flex justify-content-end mt-3">
                <?= $pager->links('default', 'my_template') ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($ventasPdf)): ?>
            <div class="row bg-light rounded-2 ps-4 pe-4 d-flex justify-content-center">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 bg-white mt-3 mb-3 shadow rounded-2 me-xl-3 me-lg-3">
                    <h4 class="text-center mt-3 mb-3">Resumen estadístico</h4>
                    <ul class="list-unstyled ps-3">
                        <li><b>Cantidad de ventas:</b> <?= $resumen['cantidadVentas'] ?></li>
                        <li><b>Cantidad de clientes:</b> <?= $resumen['cantidadClientes'] ?></li>
                        <li><b>Venta más alta:</b> $<?= number_format($resumen['ventaMax'], 2) ?></li>
                        <li><b>Venta más baja:</b> $<?= number_format($resumen['ventaMin'], 2) ?></li>
                        <li><b>Promedio por factura:</b> $<?= number_format($resumen['promedioFactura'], 2) ?></li>
                        <li><b>Cliente más frecuente:</b> <?= $resumen['clienteFrecuente'] ?></li>
                        <li><b>Día con mayor facturación:</b> <?= $resumen['diaMayorFacturacion'] ?> ($<?= number_format($resumen['montoDiaMayor'], 2) ?>)</li>
                        <li><b>Método de pago más usado:</b> <?= $resumen['metodoMasUsado'] ?> (<?= $resumen['cantidadMetodoMasUsado'] ?> veces)</li>
                        <li><b>Producto más vendido:</b> <?= $resumen['productoMasVendido'] ?> (<?= $resumen['cantidadProductoMasVendido'] ?> ventas)</li>
                        <li><b>Cliente con mayor facturación:</b> <?= $resumen['clienteMayorFacturacion'] ?> ($<?= number_format($resumen['montoClienteMayor'], 2) ?>)</li>
                        <li><b>TOTAL:</b> $<?= number_format($resumen['totalVentas'], 2) ?></li>
                    </ul>
                </div>
                <!-- Gráficos -->
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 bg-white mt-3 mb-3 shadow rounded-2 ms-xl-3 ms-lg-3">
                    <h4 class="text-center mt-3 mb-3">Evolución temporal de ventas</h4>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <canvas id="ventasLineChart" style="max-height:400px;"></canvas>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 bg-white mt-3 mb-3 shadow rounded-2 me-xl-3 me-lg-3">
                    <h4 class="text-center mt-3 mb-3">Ventas por producto</h4>
                    <div class="mt-3 mb-3">
                        <canvas id="ventasBarChart" style="max-height:400px;"></canvas>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 bg-white mt-3 mb-3 shadow rounded-2 ms-xl-3 ms-lg-3">
                    <h4 class="text-center mt-3 mb-3">Distribución por cliente frecuente</h4>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <canvas id="ventasPieChart" style="max-height:400px;"></canvas>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

<!-- Script de los Gráficos -->
<script>
    const ventasPorMes = <?= json_encode($ventasPorMes) ?>;
    const clientes = <?= json_encode($clientes) ?>;
    const ventasPorCliente = <?= json_encode($ventasPorCliente) ?>;
    const productos = <?= json_encode($productos) ?>;
    const ventasPorProducto = <?= json_encode($ventasPorProducto) ?>;

    // Función para generar colores aleatorios
    function generarColores(cantidad) {
        const colores = [];
        for (let i = 0; i < cantidad; i++) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            colores.push(`rgba(${r},${g},${b},0.7)`);
        }
        return colores;
    }

    // Gráfico de líneas: evolución temporal
    new Chart(document.getElementById('ventasLineChart'), {
        type: 'line',
        data: {
            labels: Object.keys(ventasPorMes), // Meses
            datasets: [{
                label: 'Ventas',
                data: Object.values(ventasPorMes), // Totales por mes
                borderColor: 'blue',
                backgroundColor: 'rgba(0,0,255,0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: { responsive: true }
    });

    // Gráfico de torta: distribución por cliente frecuente
    new Chart(document.getElementById('ventasPieChart'), {
        type: 'pie',
        data: {
            labels: clientes, // Nombres de clientes
            datasets: [{
                data: ventasPorCliente, // Cantidad de compras por cliente
                backgroundColor: generarColores(clientes.length)
            }]
        },
        options: { responsive: true }
    });

    // Gráfico de barras: ventas por productos
    new Chart(document.getElementById('ventasBarChart'), {
        type: 'bar',
        data: {
            labels: productos, // Nombres de productos
            datasets: [{
                label: 'Cantidad vendida',
                data: ventasPorProducto, // Cantidad de ventas por producto
                backgroundColor: generarColores(productos.length)
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<!-- Script para Generar los PDF -->
<script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("btnImprimirVentas").addEventListener("click", function(e){
            e.preventDefault();
            imprimirVentas();
        });
    });

    function imprimirVentas() { 
        // Mostrar confirmación
        var confirmar = confirm("¿Quieres descargar el PDF de las ventas?");
        if (!confirmar) {
            return;
        }

        var contenido = `
            <h2 class="text-center mb-4">Reportes de Todas las Ventas</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="border">Titular</th>
                        <th class="border">Fecha (Tiempo)</th>
                        <th class="border">Producto</th>
                        <th class="border">Cantidad</th>
                        <th class="border">Precio unitario</th>
                        <th class="border">Subtotal</th>
                        <th class="border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $ventasAgrupadas = [];
                    foreach($ventasPdf as $venta) {
                        $ventasAgrupadas[$venta['id_venta_cabecera']][] = $venta;
                    }

                    foreach($ventasAgrupadas as $idVenta => $productos) {
                        $totalVenta = 0;
                        foreach($productos as $p) {
                            $totalVenta += $p['cantidad'] * $p['precio'];
                        }

                        foreach($productos as $i => $prod) {
                            $fechaObj = new DateTime($prod['fecha']);
                            $soloFecha = $fechaObj->format('Y-m-d');
                            $soloHora  = $fechaObj->format('H:i:s');
                            $subtotal  = $prod['cantidad'] * $prod['precio'];

                            echo "<tr class='border-top'>
                                <td class='border'>{$prod['usuario_nombre']}</td>
                                <td class='border'>{$soloFecha} ({$soloHora})</td>
                                <td class='border'>{$prod['producto_nombre']}</td>
                                <td class='border'>{$prod['cantidad']}</td>
                                <td class='border'>$".number_format($prod['precio'],2)."</td>
                                <td class='border'>$".number_format($subtotal,2)."</td>";
                            
                            if ($i == 0) {
                                $rowspan = count($productos);
                                echo "<td rowspan='{$rowspan}' class='border text-center align-middle fw-bold'>
                                        $".number_format($totalVenta,2)."
                                    </td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        `;

        var ventana = window.open('', '', 'height=800,width=1000');
        ventana.document.write('<html><head><title>Listado de Ventas</title>');
        ventana.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">');
        ventana.document.write('</head><body>');
        ventana.document.write(contenido);
        ventana.document.write('</body></html>');
        ventana.document.close();

        ventana.onload = function() {
            ventana.focus();
            ventana.print();
        };
    }
</script>