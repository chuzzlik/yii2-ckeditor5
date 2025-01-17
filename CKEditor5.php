<?php

namespace chuzzlik\ckeditor5;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

abstract class CKEditor5 extends InputWidget
{
    /**
     * @var string
     */
    public $editorType = 'Classic';

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var array Toolbar options array
     */
    public $toolbar = [];

    /**
     * @var string Url to image upload
     */
    public $uploadUrl = '';

    /**
     * @var array
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets($this->getView());
        $this->registerEditorJS();
        $this->printEditorTag();
    }

    /**
     * Registration JS
     */
    protected function registerEditorJS()
    {
		if (!empty($this->toolbar)) {
            $this->clientOptions['toolbar'] = $this->toolbar;
        }

        $clientOptions = Json::encode($this->clientOptions);

        $js = new JsExpression(
			"function FileCustomUploadAdapterPlugin( editor ) {
				editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
					return new FileUploadAdapter(loader, editor.config);
				};
			}
			var clientOptions = JSON.parse('$clientOptions');
			clientOptions['extraPlugins'] = [FileCustomUploadAdapterPlugin];
			if (typeof $this->editorType == 'undefined' || !$this->editorType) {var $this->editorType = {};} ".
            $this->editorType . "Editor.create(document.querySelector('#{$this->options['id']}'), clientOptions ).catch(error => {console.error(error);});"
        );
        $this->view->registerJs($js);
    }

    /**
     * @param \yii\web\View $view
     */
    protected function registerAssets($view)
    {
		$assets = [];
		switch ($this->editorType) {
            case 'Classic':
				$assets = ClassicAssets::register($view);
			break;
            case 'Balloon':
				$assets = BalloonAssets::register($view);
			break;
            case 'Inline':
				$assets = InlineAssets::register($view);
			break;
		}
		
		if (array_key_exists('language',$this->clientOptions)) {
			$assets->js[] = 'translations/'.$this->clientOptions['language'].'.js';
		}
        CKEditorAssets::register($view);
    }

    /**
     * View tag for editor
     */
    protected function printEditorTag(){}

}
