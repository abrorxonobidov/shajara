<?php

namespace common\models\marriage;

/**
 * This is the ActiveQuery class for [[Marriage]].
 *
 * @see Marriage
 */
class MarriageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Marriage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Marriage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
