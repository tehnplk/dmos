<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_tmb".
 *
 * @property string|null $code
 * @property string|null $name
 * @property string|null $amp
 * @property int|null $POP
 * @property int|null $SICK
 * @property int|null $DEATH
 */
class Ctmb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ctmb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['POP', 'SICK', 'DEATH'], 'integer'],
            [['code'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 20],
            [['amp'], 'string', 'max' => 4],
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
            'amp' => 'Amp',
            'POP' => 'Pop',
            'SICK' => 'Sick',
            'DEATH' => 'Death',
        ];
    }
}
