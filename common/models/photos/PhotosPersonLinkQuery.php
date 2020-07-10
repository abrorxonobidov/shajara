<?php

namespace common\models\photos;

/**
 * This is the ActiveQuery class for [[PhotosPersonLink]].
 *
 * @see PhotosPersonLink
 */
class PhotosPersonLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PhotosPersonLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PhotosPersonLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
