<?php

namespace Zelenin\yii\modules\RequestLog\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use Zelenin\yii\modules\RequestLog\Module;

class RequestLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%request_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'app_id' => Module::t('App ID'),
            'route' => Module::t('Route'),
            'user_id' => Module::t('User ID'),
            'ip' => Module::t('IP'),
            'datetime' => Module::t('Datetime'),
            'user_agent' => Module::t('User agent')
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['app_id']
                ],
                'value' => function ($event) {
                    return Yii::$app->id;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['route']
                ],
                'value' => function ($event) {
                    return Yii::$app->requestedRoute;
                }
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['user_id']
                ]
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['ip']
                ],
                'value' => function ($event) {
                    return Yii::$app->getRequest()->getUserIP();
                }
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['datetime']
                ],
                'value' => new Expression('now()')
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['user_agent']
                ],
                'value' => function ($event) {
                    return Yii::$app->getRequest()->getUserAgent();
                }
            ]
        ];
    }

    /**
     * @return ActiveQuery|null
     */
    public function getUser()
    {
        $primaryKey = Yii::$app->getUser()->getIdentity()->primaryKey()[0];
        return $this->hasOne(Yii::$app->getUser()->identityClass, [$primaryKey => 'user_id']);
    }
}
