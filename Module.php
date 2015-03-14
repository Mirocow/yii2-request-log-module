<?php

namespace Zelenin\yii\modules\RequestLog;

use Yii;

class Module extends \yii\base\Module
{
    /** @var string */
    public $usernameAttribute = 'username';

    /**
     * @param string $message
     * @param array $params
     * @param string|null $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::t('zelenin/modules/request-log', $message, $params, $language);
    }
}
