<?php

namespace common\models\photos;

use common\models\person\Person;
use common\models\user\User;
use Yii;

/**
 * This is the model class for table "photos_person_link".
 *
 * @property int $id
 * @property int $photo_id
 * @property int $person_id
 * @property string $description
 * @property int $creator_id
 * @property int $modifier_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Person $person
 * @property Photos $photo
 * @property User $creator
 * @property User $modifier
 */
class PhotosPersonLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos_person_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'photo_id', 'person_id'], 'required'],
            [['id', 'photo_id', 'person_id', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['person_id' => 'id']],
            [['photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Photos::class, 'targetAttribute' => ['photo_id' => 'id']],
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
            'photo_id' => 'Photo ID',
            'person_id' => 'Person ID',
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
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Photos::class, ['id' => 'photo_id']);
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
     * {@inheritdoc}
     * @return PhotosPersonLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotosPersonLinkQuery(get_called_class());
    }
}
