<?php

use yii\db\Migration;
use yii\db\Schema;
use mirocow\requestlog\RequestLog\models\RequestLog;

class m141010_072330_createRequestLogTable extends Migration
{
    public function safeUp()
    {
        $this->createTable(RequestLog::tableName(), [
            'id' => Schema::TYPE_PK,
            'app_id' => Schema::TYPE_STRING . ' not null',
            'route' => Schema::TYPE_STRING . ' not null',
            'params' => Schema::TYPE_STRING . ' not null',
            'user_id' => Schema::TYPE_INTEGER,
            'ip' => Schema::TYPE_STRING,
            'datetime' => Schema::TYPE_DATETIME . ' not null',
            'user_agent' => Schema::TYPE_STRING
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(RequestLog::tableName());
        return true;
    }
}
