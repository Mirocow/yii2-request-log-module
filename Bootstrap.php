<?php

namespace Zelenin\yii\modules\RequestLog;

use Yii;
use yii\base\BootstrapInterface;
use Zelenin\yii\modules\RequestLog\behaviors\RequestLogBehavior;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->attachBehavior('request-log', RequestLogBehavior::className());
    }
}
