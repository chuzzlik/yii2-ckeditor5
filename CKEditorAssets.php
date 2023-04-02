<?php

namespace chuzzlik\ckeditor5;

use yii\web\AssetBundle;

class CKEditorAssets extends AssetBundle
{

    public $sourcePath = '@vendor/chuzzlik/yii2-ckeditor5/assets/';
    public $css = [
		'styles.css'
    ];

    public $js = [
        'ckeditor-file-upload.js',
    ];

    public $depends = [
    ];
}