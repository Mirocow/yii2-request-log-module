<?php
/**
 * @var View $this
 * @var RequestLogSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use Zelenin\yii\modules\RequestLog\models\RequestLog;
use Zelenin\yii\modules\RequestLog\models\search\RequestLogSearch;
use Zelenin\yii\modules\RequestLog\Module;

/** @var IdentityInterface|ActiveRecord $identity */
$identity = Yii::$app->getUser()->identityClass;

$this->title = Module::t('Requests');
echo Breadcrumbs::widget(['links' => [
    $this->title
]]);
?>
<div class="request-log-default-index">
    <h3><?= Html::encode($this->title) ?></h3>

    <?php
    Pjax::begin();
    echo GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'value' => function ($model, $index, $dataColumn) {
                    /** @var RequestLog $model */
                    return $model->id;
                },
                'filter' => false
            ],
            'app_id',
            'route',
            'params',
            [
                'attribute' => 'user_id',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->user ? $model->user->{Module::getInstance()->usernameAttribute} : Module::t('Guest');
                },
                'filter' => ArrayHelper::map($identity::find()->all(), 'id', Module::getInstance()->usernameAttribute)
            ],
            'ip',
            [
                'attribute' => 'datetime',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->datetime;
                },
                'filter' => false
            ],
            [
                'attribute' => 'user_agent',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->user_agent;
                },
                'filter' => false
            ],
        ]
    ]);
    Pjax::end();
    ?>
</div>
