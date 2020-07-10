<?php

namespace common\models\person;

use common\models\user\User;
use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $title
 * @property string $name
 * @property string $surname
 * @property string $fathers_name
 * @property string $date_of_birth
 * @property string $date_of_death
 * @property int $generation_id
 * @property string $description
 * @property int $gender_id
 * @property string $address
 * @property string $citizenship
 * @property int $parent_marriage_id
 * @property int $education_id
 * @property string $phone
 * @property string $profession
 * @property int $creator_id
 * @property int $modifier_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Marriage[] $marriages
 * @property Marriage[] $marriages0
 * @property Marriage $parentMarriage
 * @property User $creator
 * @property User $modifier
 * @property PhotosPersonLink[] $photosPersonLinks
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'gender_id', 'citizenship'], 'required'],
            [['date_of_birth', 'date_of_death', 'created_at', 'updated_at'], 'safe'],
            [['generation_id', 'gender_id', 'parent_marriage_id', 'education_id', 'creator_id', 'modifier_id'], 'integer'],
            [['title', 'name', 'surname', 'fathers_name', 'citizenship', 'profession'], 'string', 'max' => 50],
            [['description', 'address', 'phone'], 'string', 'max' => 255],
            [['parent_marriage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marriage::class, 'targetAttribute' => ['parent_marriage_id' => 'id']],
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
            'title' => 'Title',
            'name' => 'Name',
            'surname' => 'Surname',
            'fathers_name' => 'Fathers Name',
            'date_of_birth' => 'Date Of Birth',
            'date_of_death' => 'Date Of Death',
            'generation_id' => 'Generation ID',
            'description' => 'Description',
            'gender_id' => 'Gender ID',
            'address' => 'Address',
            'citizenship' => 'Citizenship',
            'parent_marriage_id' => 'Parent Marriage ID',
            'education_id' => 'Education ID',
            'phone' => 'Phone',
            'profession' => 'Profession',
            'creator_id' => 'Creator ID',
            'modifier_id' => 'Modifier ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarriages()
    {
        return $this->hasMany(Marriage::class, ['husband_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarriages0()
    {
        return $this->hasMany(Marriage::class, ['wife_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentMarriage()
    {
        return $this->hasOne(Marriage::class, ['id' => 'parent_marriage_id']);
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
        return $this->hasMany(PhotosPersonLink::class, ['person_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }
}
