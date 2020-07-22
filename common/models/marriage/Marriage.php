<?php

namespace common\models\marriage;

use common\models\base\LocalActiveRecord;
use common\models\person\Person;
use common\models\user\User;

/**
 * This is the model class for table "marriage".
 *
 * @property int $id
 * @property int $husband_id
 * @property int $wife_id
 * @property string $date_of_marriage
 * @property string $date_of_divorce
 * @property int $order_husband
 * @property int $order_wife
 * @property string $description
 * @property int $status_id
 * @property int $creator_id
 * @property int $modifier_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property string $fullIdentity
 *
 * @property Person $husband
 * @property Person $wife
 * @property User $creator
 * @property User $modifier
 * @property Person[] $people
 */
class Marriage extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marriage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['husband_id', 'wife_id'], 'required'],
            [['husband_id', 'wife_id', 'order_husband', 'order_wife', 'status_id', 'creator_id', 'modifier_id'], 'integer'],
            [['date_of_marriage', 'date_of_divorce', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['order_husband', 'order_wife'], 'default', 'value' => 1],
            [['husband_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['husband_id' => 'id']],
            [['wife_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['wife_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $a = parent::attributeLabels();
        return array_merge($a,
            [
                'id' => 'ID',
                'husband_id' => 'Er',
                'husband.fullIdentity' => 'Er',
                'wife_id' => 'Xotin',
                'wife.fullIdentity' => 'Xotin',
                'date_of_marriage' => 'Nikohlangan sana',
                'date_of_divorce' => 'Ajrashgan sana (Agar ajrashgan bo‘lsa)',
                'order_husband' => 'Erning nikohi tartibi',
                'order_wife' => 'Xotinning nikohi tartibi',
                'description' => 'Izoh',
                'status_id' => 'Status ID',
                'status' => 'Status',
            ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHusband()
    {
        return $this->hasOne(Person::class, ['id' => 'husband_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWife()
    {
        return $this->hasOne(Person::class, ['id' => 'wife_id']);
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
    public function getPeople()
    {
        return $this->hasMany(Person::class, ['parent_marriage_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MarriageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarriageQuery(get_called_class());
    }

    public static function getStatusList()
    {
        return [
            1 => 'Kuchda qolgan',
            2 => 'Ajrashgan',
        ];
    }

    public function getStatus()
    {
        return self::getStatusList()[$this->status_id];
    }

    public function getFullIdentity()
    {
        return $this->husband->fullIdentity . ' - ' . $this->wife->fullIdentity;
    }
}
