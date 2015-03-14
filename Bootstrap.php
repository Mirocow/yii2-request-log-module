<?php

namespace Zelenin\yii\modules\RequestLog;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\Application;
use Zelenin\yii\modules\RequestLog\behaviors\RequestLogBehavior;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $app->attachBehavior('request-log', RequestLogBehavior::className());
        }
    }
}
