<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    //public $baseUrl = '@web';
    public $sourcePath = '@bower/spirit/';
    public $css = [
        'css/bootstrap.css',
        'fonts/font-awesome/css/font-awesome.css',
        'css/owl.carousel.css',
        'css/owl.theme.css',
        'css/style.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/modernizr.custom.js',
        'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
        'js/jquery.1.11.1.js',
        'js/bootstrap.js',
        'js/SmoothScroll.js',
        'js/jquery.isotope.js',
        'js/owl.carousel.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
