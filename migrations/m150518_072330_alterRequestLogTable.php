<?php

use yii\db\Migration;
use yii\db\Schema;
use Zelenin\yii\modules\RequestLog\models\RequestLog;

class m150518_072330_alterRequestLogTable extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(RequestLog::tableName(), 'params', Schema::TYPE_TEXT);
    }

    public function safeDown()
    {
        $this->alterColumn(RequestLog::tableName(), 'params', Schema::TYPE_STRING . ' not null');
        return true;
    }
}
