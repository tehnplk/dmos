<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_moo".
 *
 * @property string|null $code
 * @property string|null $name
 * @property string|null $tmb
 * @property string|null $amp
 * @property string|null $STATION
 * @property int|null $POP
 */
class Cmoo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cmoo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['POP'], 'integer'],
            [['code'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 23],
            [['tmb'], 'string', 'max' => 6],
            [['amp'], 'string', 'max' => 4],
            [['STATION'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'tmb' => 'Tmb',
            'amp' => 'Amp',
            'STATION' => 'Station',
            'POP' => 'Pop',
        ];
    }
}
