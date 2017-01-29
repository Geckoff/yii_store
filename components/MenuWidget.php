<?php

namespace app\components;

use yii\base\Widget;
use app\models\Category;
use Yii;

/**
* Buliding Category menu.
* Based on Tommy Lacroix function of composing infinite levels nested tree.
* $tpl - type of widget (menu list or select or menu list for sorting items' order that is used in admin dashboard)
**/

class MenuWidget extends Widget  {

    public $tpl;        // parameter that is used while calling function widget() for showing widget in view file
    public $data;       // categories array
    public $model;
    public $tree;       // setting of tree array
    public $menuHtml;
    public $id;
    public $category_id;
    public $category_add;

    public function init() {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run() {

        $this->data = Category::find()->indexBy('id')->asArray()->orderBy(['order' => SORT_ASC])->all();    // indexBy() - what field is used for array indexing
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        return $this->menuHtml;
    }

    protected function getTree() {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }
            else {
                //$this->data[$node['parent_id']]['childs'][$id] = $node;
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '') {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
        }
        $insert_id = is_array($this->id) ? $this->id['category_id'] : $this->id;
        if ($this->tpl !== 'order.php') $str .= '<div id="add-active" data-id="'.$insert_id.'"></div>';  // fixing category menu displayng
        return $str;
    }

    protected function catToTemplate($category, $tab) {
        //ob_start();
        if ($category['active']) include __DIR__.'/menu_tpl/'.$this->tpl;
        //return ob_get_clean();
    }
}