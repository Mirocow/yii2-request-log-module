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
      if(isset($app->modules['request-log'])){
        $app->attachBehavior('request-log', RequestLogBehavior::className());
      }
    }
}
