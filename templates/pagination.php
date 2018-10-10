<?php

use razmik\helper\Html;
use razmik\helper\Url;

$firstClass = $currentPage > 1 ? null : ' disabled';
$lastClass = $currentPage < $totalCount ? null : ' disabled';
?>

<?php if ($totalCount > 1): ?>
    <ul class="<?= $defaultListClass ?>">
        <?php if ($showDisabled || !$firstClass): ?>
            <li class="<?= $defaultItemClass . $firstClass ?>">
                <?= Html::a($firstChar, [$url, $queryParam => $currentPage - 1], ['class' => $defaultLinkClass]) ?>
            </li>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $totalCount; $i++): ?>
            <li class="<?= $defaultItemClass . ($currentPage == $i ? ' active' : null) ?>">
                <?= Html::a($i, [$url, $queryParam => $i], ['class' => $defaultLinkClass]) ?>
            </li>
        <?php endfor; ?>

        <?php if ($showDisabled || !$lastClass): ?>
            <li class="<?= $defaultItemClass . $lastClass ?>">
                <?= Html::a($lastChar, [$url, $queryParam => $currentPage + 1], ['class' => $defaultLinkClass]) ?>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>