<?php

namespace common\behaviors;

use yii\behaviors\AttributesBehavior;
use yii\db\BaseActiveRecord;
use common\exception\BehaviorException;

class ArrayToStringBehavior extends AttributesBehavior
{

    public $attrs = [];
    public $delimiter = ",";

    /**
     * @throws BehaviorException
     */
    public function init()
    {
        if (!$this->attrs) {
            throw new BehaviorException("attr parameter is required");
        }

        if (is_string($this->attrs)) {
            $this->attrs = [$this->attrs];
        }

        if (empty($this->attributes)) {
            $this->attributes = array_fill_keys($this->attrs, [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this, 'arrayToString'],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => [$this, 'arrayToString'],
                BaseActiveRecord::EVENT_AFTER_FIND => [$this, 'stringToArray']
            ]);
        }

        parent::init();
    }

    /**
     * @param $event
     * @param $attribute
     * @return mixed|string
     * @throws BehaviorException
     */
    public function arrayToString($event, $attribute)
    {
            if (!$this->owner->hasProperty($attribute)) {
                throw new BehaviorException($attribute . " have not found");
            }

        $array = $this->owner->$attribute;
        if (!$array) return $array;
        $array = implode($this->delimiter, $array);
        return $array;
    }

    /**
     * @param $event
     * @param $attribute
     * @return array|mixed
     * @throws BehaviorException
     */
    public function stringToArray($event, $attribute)
    {
            if (!$this->owner->hasProperty($attribute)) {
                throw new BehaviorException($attribute . " have not found");
            }
        $string = $this->owner->$attribute;
        $string = explode($this->delimiter, $string);
        return $string;
    }
}