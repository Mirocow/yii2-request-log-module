<?php

namespace mirocow\requestlog\RequestLog\controllers;

use Yii;
use yii\web\Controller;
use mirocow\requestlog\RequestLog\models\search\RequestLogSearch;

class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestLogSearch;
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->get());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
