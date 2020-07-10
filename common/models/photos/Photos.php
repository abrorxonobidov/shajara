<?php

namespace common\models\photos;

use common\models\user\User;
use Yii;

/**
 * This is the model class for table "photos".
 *
 * @property int $id
 * @property string $file_name
 * @property string $description
 * @property int $creator_id
 * @property int $modifier_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $creator
 * @property User $modifier
 * @property PhotosPersonLink[] $photosPersonLinks
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_name'], 'required'],
            [['id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'description' => 'Description',
            'creator_id' => 'Creator ID',
            'modifier_id' => 'Modifier ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModifier()
    {
        return $this->hasOne(User::class, ['id' => 'modifier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotosPersonLinks()
    {
        return $this->hasMany(PhotosPersonLink::class, ['photo_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PhotosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotosQuery(get_called_class());
    }
}
