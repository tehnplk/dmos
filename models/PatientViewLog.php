<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient_view_log".
 *
 * @property int $id
 * @property string|null $patient_id
 * @property string|null $viewer_user_id
 * @property string|null $viewer_user_hoscode
 * @property string|null $viewer_user_hosname
 * @property string|null $view_date
 * @property string|null $ip_viewer
 */
class PatientViewLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient_view_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['view_date'], 'safe'],
            [['patient_id', 'viewer_user_id', 'viewer_user_hoscode', 'viewer_user_hosname', 'ip_viewer'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patient_id' => 'Patient ID',
            'viewer_user_id' => 'Viewer User ID',
            'viewer_user_hoscode' => 'Viewer User Hoscode',
            'viewer_user_hosname' => 'Viewer User Hosname',
            'view_date' => 'View Date',
            'ip_viewer' => 'Ip Viewer',
        ];
    }
}
