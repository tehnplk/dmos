<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_dx".
 *
 * @property string|null $code
 * @property string|null $name
 */
class Cdx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdx';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'วินิจฉัย',
        ];
    }
}
