<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="page-item ms-2">
                <b>
                    <a class="page-link rounded-2 text-dark" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                        <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                    </a>
                </b>
			</li>
			<li class="page-item">
                <b>
                    <a class="page-link rounded-2 text-dark" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                        <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
                    </a>
                </b>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li class="page-item ms-2" <?= $link['active'] ? 'class="active"' : '' ?>>
                <b>
                    <a class="page-link rounded-2 text-dark" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </b>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="page-item me-2">
                <b>
                    <a class="page-link rounded-2 text-dark" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                        <span aria-hidden="true"><?= lang('Pager.next') ?></span>
                    </a>
                </b>
			</li>
			<li class="page-item">
                <b>
                    <a class="page-link rounded-2 text-dark" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                        <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                    </a>
                </b>
			</li>
		<?php endif ?>
	</ul>
</nav>
