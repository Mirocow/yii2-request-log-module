<?php

namespace mirocow\requestlog\RequestLog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use mirocow\requestlog\RequestLog\models\RequestLog;

class RequestLogSearch extends RequestLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [];
        foreach ($this->attributes() as $attribute) {
            $rules[$attribute] = [$attribute, 'safe'];
        }
        return $rules;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find()
            ->joinWith(['user'])
            ->orderBy(['datetime' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'app_id', $this->app_id]);
        $query->andFilterWhere(['like', 'route', $this->route]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
