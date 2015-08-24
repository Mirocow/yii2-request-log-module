<?php

namespace mirocow\requestlog\RequestLog;

use Yii;
use yii\base\BootstrapInterface;
use mirocow\requestlog\RequestLog\behaviors\RequestLogBehavior;

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
