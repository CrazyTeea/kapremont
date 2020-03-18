<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    private const DEV_JS = [
        'dev/index.js',
    ];
    private const DEV_CSS = [
        'dev/styles.css',
        'css/site.css'
    ];
    private const PROD_JS = [
        'vue/index.js',
    ];
    private const PROD_CSS = [
        'vue/styles.css',
        'css/site.css'
    ];

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = (YII_ENV_DEV) ? self::DEV_CSS : self::PROD_CSS;
    public $js = (YII_ENV_DEV) ? self::DEV_JS : self::PROD_JS;

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}

