<?php
namespace frontend\models;
use yii\base\Model;

class Form extends Model {
    public $first_name;
    public $last_name;
    public function rules(){
        return [
            [['first_name', 'last_name'], 'required'],
        ];
    }
}