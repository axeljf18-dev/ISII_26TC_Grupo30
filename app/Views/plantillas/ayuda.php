<main>
    <div class="row bg-light rounded-2 contenedor__div-ayuda">
        <div class="col-12">
            <h1 class="text-center mb-3">¿Con qué podemos ayudarte?</h1>
        </div>
        <div class="col-12 accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item" id="comprar">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed mb-1 border boton__acordeon-1" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        ¿Cómo comprar en NetShop?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse border" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <p>A continuación te dejamos los pasos para comprar en NetShop:</p>
                        <ol>
                            <li>Inicia sesión en NetShop.</li>
                            <li>Una vez que hayas ingresado, utiliza el buscador para encontrar el producto que deseas o navega por el menú principal para seleccionarlo.</li>
                            <li>Haz clic en el botón "Añadir al carrito" para agregar el producto deseado.</li>
                            <li>Accede a "Mi Carrito" y, si estás conforme con tu selección, elige un <b>método de pago</b> en el menú desplegable. Luego haz clic en el botón "Comprar" para finalizar tu transacción.</li>
                            <li>Al completar el proceso, se mostrarán los detalles de tu compra confirmando que la transacción se realizó con éxito.</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-item" id="sucursal">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed mb-1 border boton__acordeon-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        ¿Dónde encontrar nuestras sucursales?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse border" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body d-flex justify-content-center">
                        <img src="<?= base_url('assets/img/Ubicacion de Sucursal.png'); ?>" alt="Ubicacion de la Sucursal" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>