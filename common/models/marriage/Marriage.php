<?php

namespace common\models\marriage;

use common\models\person\Person;
use common\models\user\User;
use Yii;

/**
 * This is the model class for table "marriage".
 *
 * @property int $id
 * @property int $husband_id
 * @property int $wife_id
 * @property string $date_of_marriage
 * @property string $date_of_divorce
 * @property int $order
 * @property string $description
 * @property int $status_id
 * @property int $creator_id
 * @property int $modifier_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Person $husband
 * @property Person $wife
 * @property User $creator
 * @property User $modifier
 * @property Person[] $people
 */
class Marriage extends \yii\db\ActiveRecord
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
            [['husband_id', 'wife_id', 'order', 'status_id', 'creator_id', 'modifier_id'], 'integer'],
            [['date_of_marriage', 'date_of_divorce', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
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
        return [
            'id' => 'ID',
            'husband_id' => 'Husband ID',
            'wife_id' => 'Wife ID',
            'date_of_marriage' => 'Date Of Marriage',
            'date_of_divorce' => 'Date Of Divorce',
            'order' => 'Order',
            'description' => 'Description',
            'status_id' => 'Status ID',
            'creator_id' => 'Creator ID',
            'modifier_id' => 'Modifier ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
}
