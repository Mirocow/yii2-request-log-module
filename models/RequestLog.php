<?php

namespace mirocow\requestlog\RequestLog\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use mirocow\requestlog\RequestLog\Module;

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
            'params' => Module::t('Params'),
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
        list ($route, $params) = Yii::$app->getRequest()->resolve();

        $isWebApp = Yii::$app instanceof \yii\web\Application;

        $webAppBehaviors = [];
        $commonBehaviors = [
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
                'value' => function ($event) use ($route) {
                    return $route;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['params']
                ],
                'value' => function ($event) use ($params, $isWebApp) {
                    if ($isWebApp) {
                      $params['_GET'] = json_encode(Yii::$app->request->get(), JSON_PRETTY_PRINT);
                      $params['_POST'] = json_encode(Yii::$app->request->post(), JSON_PRETTY_PRINT);
                    } else {
                      array_walk_recursive($params, function (&$value) {
                          $value = json_encode($value, JSON_PRETTY_PRINT);
                      });                      
                    }
                    return var_export($params, true);
                }
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['datetime']
                ],
                'value' => new Expression('now()')
            ]
        ];

        if ($isWebApp) {
            $webAppBehaviors = [
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
        return ArrayHelper::merge($commonBehaviors, $webAppBehaviors);
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
