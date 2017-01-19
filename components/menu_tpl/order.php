<li>
    <span class="arrow-pos-block">
        <a class="move-cat move-cat-up" href="#" data-order="<?=$category['order']?>" data-direction="up" data-parent="<?=$category['parent_id']?>" data-id="<?=$category['id']?>"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></a>
        <a class="move-cat move-cat-down" href="#" data-order="<?=$category['order']?>" data-direction="down" data-parent="<?=$category['parent_id']?>" data-id="<?=$category['id']?>"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></a>
    </span>
    <?php
        /*if (!empty($this->id) && $this->id !== '0') {
            $category_id = is_array($this->id) ? $this->id['category_id'] : $this->id;
            if ($category_id == $category['id'] ) $active = 'class="active"';
            else $active = '';
        }*/
    ?>

    <?=$category['name'] ?>

    <?php if (isset($category['childs'])): ?>
        <ul style="display:block" class="ul-menu-admin-order">
            <?php $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>

</li>