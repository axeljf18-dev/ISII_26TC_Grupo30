<?php 
    $session = session();
    $valorQuery = $session->getFlashdata('queryValor');
?>

<form class="d-flex justify-content-center align-items-center contenedor__form-search" action="<?php echo base_url('enviar-formQuery'); ?>" method="GET">
    <div class="d-flex align-items-center form__div-1-search">
        <input type="search" name="query" placeholder="Escribe el producto que quieres buscar..." value="<?= $valorQuery; ?>" class="border shadow-sm form__div-1-search-input">
    </div>
    <div class="d-flex align-items-center form__div-2-search">
        <button class="bg-white border shadow-sm form__div-2-button-search">
            <img src="<?= base_url('assets/img/lupa.png'); ?>" alt="Lupa" height="20px" class="opacity-75">
        </button>
    </div>
</form>