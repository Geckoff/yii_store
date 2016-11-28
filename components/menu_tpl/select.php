<?php
$selected = '';
$disabled = '';
$selected_var = isset($this->model->parent_id) ? $this->model->parent_id : $this->model->category_id ;
//$selected_var = isset($this->model->category_id) ? $this->model->category_id : '';

if ($category['id'] == $selected_var) $selected = 'selected';
if (isset($this->model->parent_id)) {
    if ($category['id'] == $this->model->id) $disabled = 'disabled';
}
?>

<option value="<?= $category['id'] ?>" <?= $selected ?> <?= $disabled ?> ><?= $tab.$category['name'] ?></option>
<?php if (isset($category['childs'])): ?>
    <ul>
        <?php $this->getMenuHtml($category['childs'], $tab.'--'); ?>
    </ul>
<?php endif; ?>
