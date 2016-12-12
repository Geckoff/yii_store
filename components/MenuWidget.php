<?php

namespace app\components;

use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget  {

    public $tpl;        // parameter that is used while calling function widget() for showing widget in view file
    public $data;       // categories array
    public $model;
    public $tree;       // setting of tree array
    public $menuHtml;
    public $id;

    public function init() {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run() {
        // get cache
        /*if ($this->tpl == 'menu.php'){        // pulling out menu from cache only for client's side
            $menu = Yii::$app->cache->get('menu');
            if ($menu) {
                return $menu;
            }
        }*/


        $this->data = Category::find()->indexBy('id')->asArray()->all();    // indexBy() - what field is used for array indexing
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        //set cache
        /*if ($this->tpl == 'menu.php'){         // setting up menu to cache only for client's side
            Yii::$app->cache->set('menu', $this->menuHtml, 60);
        }*/
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
        $str .= '<div id="add-active" data-id="'.$insert_id.'"></div>';
        return $str;
    }

    protected function catToTemplate($category, $tab) {
        //ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        //return ob_get_clean();
    }
}