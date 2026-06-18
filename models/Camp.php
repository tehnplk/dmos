<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "c_amp".
 *
 * @property string|null $code
 * @property string|null $name
 * @property int|null $POP
 * @property int|null $ZONE
 * @property int|null $HC507
 * @property int|null $HCNO
 * @property int|null $HCOK
 * @property int|null $HCTT
 * @property int|null $HCIN
 * @property int|null $HP507
 * @property int|null $HPNO
 * @property int|null $HPOK
 * @property int|null $HPTT
 * @property int|null $HPIN
 * @property int|null $SICK
 * @property int|null $DEATH
 */
class Camp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'camp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['POP', 'ZONE', 'HC507', 'HCNO', 'HCOK', 'HCTT', 'HCIN', 'HP507', 'HPNO', 'HPOK', 'HPTT', 'HPIN', 'SICK', 'DEATH'], 'integer'],
            [['code'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 50],
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
            'POP' => 'Pop',
            'ZONE' => 'Zone',
            'HC507' => 'Hc507',
            'HCNO' => 'Hcno',
            'HCOK' => 'Hcok',
            'HCTT' => 'Hctt',
            'HCIN' => 'Hcin',
            'HP507' => 'Hp507',
            'HPNO' => 'Hpno',
            'HPOK' => 'Hpok',
            'HPTT' => 'Hptt',
            'HPIN' => 'Hpin',
            'SICK' => 'Sick',
            'DEATH' => 'Death',
        ];
    }
}
