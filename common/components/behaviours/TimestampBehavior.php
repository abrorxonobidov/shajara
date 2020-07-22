<?php
/**
 * Created by PhpStorm.
 * User: Farrukh
 * Date: 08.11.2016
 * Time: 14:49
 */

namespace common\components\behaviours;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property string $creatorIdAttribute
 * @property string $modifierIdAttribute
 * @property string $createdAtAttribute
 * @property string $updatedAtAttribute
 * @property string $value
 * @property boolean $timestamp
 */
class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
	public $creatorIdAttribute = 'creator_id';
	public $modifierIdAttribute  = 'modifier_id';
	public $timestamp = false;

	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
		];
	}

	public function beforeValidate($event)
	{
		/** @var ActiveRecord $owner */
		$owner = $this->owner;
		if (strstr($owner::className(), 'Search')) return;

		if ($owner->isNewRecord && $owner->hasAttribute($this->createdAtAttribute)){
            $owner[$this->createdAtAttribute] = $this->getValue($event);
            $this->setUserId($this->creatorIdAttribute);
		}

		if ($owner->hasAttribute($this->updatedAtAttribute)) {
            $owner[$this->updatedAtAttribute] = $this->getValue($event);
            $this->setUserId($this->modifierIdAttribute);
        }
	}

	protected function getValue($event)
	{
		$value = parent::getValue($event);
		return $this->timestamp === false ? $value : date('Y-m-d H:i:s', $value);
	}

	/**
     * @param string $attribute
     */
	protected function setUserId($attribute)
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        $user = Yii::$app->user;
        if ($owner->hasAttribute($attribute) && !$user->isGuest)
            $owner[$attribute] = $user->id;
    }
}