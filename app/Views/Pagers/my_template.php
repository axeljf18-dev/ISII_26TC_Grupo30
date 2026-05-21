<?php if ($pager): ?>
    <div class="d-flex justify-content-end">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Botón anterior -->
                <?php if ($pager->hasPreviousPage()): ?>
                    <li class="page-item">
                        <a class="page-link fw-bold" style="background-color:#FFFFFF; color:#871ED9; border:1px solid #871ED9;" href="<?= $pager->getPreviousPage() ?>" aria-label="Anterior">
                            &lt;
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Números -->
                <?php foreach ($pager->links() as $link): ?>
                    <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                        <a class="page-link fw-bold" style="background-color:#FFFFFF; color:#871ED9; border:1px solid #871ED9;" href="<?= $link['uri'] ?>">
                            <?= $link['title'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <!-- Botón siguiente -->
                <?php if ($pager->hasNextPage()): ?>
                    <li class="page-item">
                        <a class="page-link fw-bold" style="background-color:#FFFFFF; color:#871ED9; border:1px solid #871ED9;" href="<?= $pager->getNextPage() ?>" aria-label="Siguiente">
                            &gt;
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>