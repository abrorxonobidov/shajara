<?php

namespace common\models\base;

/**
 * This is the ActiveQuery class for [[Logs]].
 *
 * @see Logs
 */
class LogsQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return Logs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Logs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
