<?php
/**
* Tamplate used for building Category Menu on client side of the website
**/
?>

<li>
    <a href="<?= \yii\helpers\Url::to(['category/view', 'slug' => $category['slug']]) ?>" data-id="<?=$category['id'] ?>" >
        <?=$category['name'] ?>
        <?php if (isset($category['childs'])): ?>
            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
        <?php endif; ?>
    </a>
    <?php if (isset($category['childs'])): ?>
        <ul>
            <?php $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>
</li>