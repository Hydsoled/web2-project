<?php

namespace common\exception;

use yii\base\Exception;

class BehaviorException extends Exception
{
    public function getName()
    {
        return "Behaviour exceptions";
    }
}