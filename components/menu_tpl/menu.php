<li>
    <?php
        /*if (!empty($this->id) && $this->id !== '0') {
            $category_id = is_array($this->id) ? $this->id['category_id'] : $this->id;
            if ($category_id == $category['id'] ) $active = 'class="active"';
            else $active = '';
        }*/
    ?>
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