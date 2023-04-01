<?php

namespace chuzzlik\ckeditor5;

use yii\web\AssetBundle;

class ClassicAssets extends AssetBundle
{

    public $sourcePath = '@vendor/chuzzlik/yii2-ckeditor5/ckeditor5/classic/';
    public $css = [
    ];

    public $js = [
        'ckeditor.js',
    ];

    public $depends = [
    ];
}