<?php

namespace Zelenin\yii\modules\RequestLog\behaviors;

use Yii;
use yii\base\Application;
use yii\base\Behavior;
use Zelenin\yii\modules\RequestLog\models\RequestLog;

class RequestLogBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Application::EVENT_AFTER_REQUEST => 'afterRequest'
        ];
    }

    /**
     * @param $event
     */
    public function afterRequest($event)
    {
        $request = new RequestLog;
        $request->save();
    }
}
