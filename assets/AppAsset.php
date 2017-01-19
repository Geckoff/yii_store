<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/fontawesome-stars-o.css',
        'css/prettyPhoto.css',
        'css/price-range.css',
        'css/animate.css',
    	'css/responsive.css',
        'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
        'css/main.css'
    ];
    public $js = [
        /*'js/jquery.js',
    	'js/bootstrap.min.js',*/
    	'js/jquery.scrollUp.min.js',
    	'js/price-range.js',
        'js/jquery.prettyPhoto.js',
        'js/jquery.cookie.js',
        'js/jquery.accordion.js',
        'js/jquery.barrating.js',
        'js/jquery.elevatezoom.js',
        'js/jquery-ui.js',  
        'js/main.js',
        'js/main-admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
