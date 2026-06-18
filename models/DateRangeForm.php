<?php


namespace app\models;

use yii\base\Model;

class DateRangeForm extends Model {

    public $startDate;
    public $endDate;

    public function rules() {
        return [
            [['startDate', 'endDate'], 'required'],
            [['startDate', 'endDate'], 'date', 'format' => 'php:Y-m-d'],
            ['endDate', 'compare', 'compareAttribute' => 'startDate', 'operator' => '>=', 'message' => 'วันที่ผิดพลาด.']
        ];
    }
     public function attributeLabels()
    {
        return [
            'startDate' => 'เข้ารับรักษาตั้งแต่วันที่',
            'endDate' => 'ถึงวันที่',
            
        ];
    }

}
