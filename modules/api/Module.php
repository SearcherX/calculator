<?php

namespace app\modules\api;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\api\controllers';

    public function init()
    {
        parent::init();
        Yii::configure(Yii::$app, require __DIR__ . '/config/config.php');
    }
}