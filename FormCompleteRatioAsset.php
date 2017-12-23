<?php

namespace aneeshikmat\yii2\FormCompleteRatio;

use yii\web\AssetBundle;
use Yii;

class FormCompleteRatioAsset extends AssetBundle
{
    public $direction = 'ltr';

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];


    public function init()
    {
        $this->direction= 'ltr';

        $this->sourcePath = __DIR__ . '/assets';
        $this->css = [
            'css/formCompleteRatio.css'
        ];

        // Rtl Style
        if($this->direction == 'rtl'){
            $this->css[] = 'css/formCompleteRatio-rtl.css';
        }

        $this->js = [
            'js/formCompleteRatio.js'
        ];
        parent::init();
    }

}
