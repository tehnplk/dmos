<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "patient_dc".
 *
 * @property int $id
 * @property int|null $patient_id
 * @property string|null $dc_date
 * @property string|null $dc_note
 * @property string|null $pic
 * @property string|null $hoscode
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 */
class PatientDc extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'patient_dc';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at', // The column for the creation timestamp
                'updatedAtAttribute' => 'updated_at', // The column for the update timestamp
                'value' => new \yii\db\Expression("NOW()"), // Using Unix timestamp for `INT` type columns
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by', // Attribute for the user who created the record
                'updatedByAttribute' => 'updated_by', // Attribute for the user who last updated the record
                'defaultValue' => null, // Set a default value if user is not logged in (optional)
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['patient_id'], 'integer'],
            [['dc_date', 'created_at', 'updated_at'], 'safe'],
            [['dc_note'], 'string'],
            [['pic', 'hoscode', 'created_by', 'updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'patient_id' => 'Patient ID',
            'dc_date' => 'วันที่ดำเนินการ',
            'dc_note' => 'รายละเอียด',
            'pic' => 'รูป',
            'hoscode' => 'Hoscode',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

}
