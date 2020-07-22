<?php

namespace common\models\person;

use common\components\behaviours\TimestampBehavior;
use common\models\marriage\Marriage;
use common\models\photos\PhotosPersonLink;
use common\models\user\User;

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
 * @property int $citizenship_id
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

    public function behaviors()
    {
        $b = parent::behaviors();
        $b[] = [
            'class' => TimestampBehavior::class,
            'timestamp' => true
        ];
        return $b;
    }

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
            [['title', 'gender_id', 'citizenship_id', 'generation_id'], 'required'],
            [['date_of_birth', 'date_of_death', 'created_at', 'updated_at'], 'safe'],
            [['generation_id', 'gender_id', 'parent_marriage_id', 'citizenship_id', 'education_id', 'creator_id', 'modifier_id'], 'integer'],
            [['title', 'name', 'surname', 'fathers_name', 'profession'], 'string', 'max' => 50],
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
            'title' => 'Taniqli ismi',
            'name' => 'Ismi',
            'surname' => 'Familiyasi',
            'fathers_name' => 'Otasining ismi',
            'date_of_birth' => 'Tug‘ilgan sanasi',
            'date_of_death' => 'Vafot etgan sanasi',
            'generation_id' => 'Nasli ID',
            'generation' => 'Nasli',
            'description' => 'Izoh',
            'gender_id' => 'Jinsi ID',
            'gender' => 'Jinsi',
            'address' => 'Manzili',
            'citizenship_id' => 'Fuqaroligi ID',
            'citizenship' => 'Fuqaroligi',
            'parent_marriage_id' => 'Ota-onasi',
            'education_id' => 'Ma’lumoti ID',
            'education' => 'Ma’lumoti',
            'phone' => 'Telefon',
            'profession' => 'Kasbi',
            'creator_id' => 'Yaratuvchi ID',
            'modifier_id' => 'Tahrirlovchi ID',
            'created_at' => 'Yaratilgan sana',
            'updated_at' => 'Tahrirlangan sana',
            'creator.nameAndSurname' => 'Yaratuvchi',
            'modifier.nameAndSurname' => 'Tahrirlovchi',

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

    public static function getGenerationList()
    {
        return [
            1 => 'Xo‘ja',
            2 => 'Fuqaro',
        ];
    }

    public function getGeneration()
    {
        return self::getGenerationList()[$this->generation_id];
    }

    public static function getGenderList()
    {
        return [
            1 => 'Erkak',
            2 => 'Ayol',
        ];
    }

    public function getGender()
    {
        return self::getCitizenshipList()[$this->gender_id];
    }

    public static function getCitizenshipList()
    {
        return [
            1 => 'O‘zbekiston',
            2 => 'Tojikiston',
        ];
    }

    public function getCitizenship()
    {
        return self::getCitizenshipList()[$this->citizenship_id];
    }

    public static function getEducationList()
    {
        return [
            1 => 'Aniqlanmagan',
            2 => 'Ma’lumotsiz (Hech qayerda o‘qimagan)',
            3 => 'O‘rta (Maktab)',
            4 => 'O‘rta-maxsus (Kollej, akademik litsey)',
            5 => 'Oliy (Universitet, Institut)',
            6 => 'Avvalgi ta’lim (Madrasa, Diniy)',
        ];
    }

    public function getEducation()
    {
        return self::getEducationList()[$this->education_id];
    }

}
