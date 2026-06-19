<?php

namespace app\models;

use app\components\MyMoph;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "patient_hos".
 *
 * @property int $id
 * @property string|null $pid
 * @property string|null $hoscode
 * @property string|null $hosname
 * @property string|null $hn
 * @property string|null $cid
 * @property string|null $pname
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $gender
 * @property string|null $birth_date
 * @property int|null $age_y
 * @property int|null $age_m
 * @property string|null $occupat
 * @property string|null $pic
 * @property string|null $prov
 * @property string|null $amp
 * @property string|null $tmb
 * @property string|null $moo
 * @property string|null $street
 * @property string|null $place
 * @property string|null $addr
 * @property string|null $tel
 * @property string|null $family
 * @property string|null $addr_note
 * @property string|null $date_sick
 * @property string|null $date_visit
 * @property string|null $symptom
 * @property string|null $dx
 * @property string|null $date_dx
 * @property string|null $doctor
 * @property string|null $lab
 * @property string|null $discharge_type
 * @property string|null $date_discharge
 * @property string|null $note
 * @property string|null $reporter
 * @property string|null $reporter_position
 * @property string|null $reporter_tel
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * @property string|null $accepted_hoscode
 * @property string|null $accepted_hosname
 * @property string|null $accepted_at
 * @property string|null $accepted_note
 * @property string|null $accepted_reject_at
 * @property string|null $accepted_reject_note
 * @property int|null $dc
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_note
 */
class PatientHos extends \yii\db\ActiveRecord {
    const MOPH_NOTIFY_DETAIL_URL = 'http://203.157.118.4/dmos/web/patient-hos/index?new=1';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'patient_hos';
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
            [['gender', 'lab'], 'string'],
            [['birth_date', 'date_sick', 'date_visit', 'date_dx', 'date_discharge', 'created_at', 'updated_at', 'accepted_at', 'accepted_reject_at'], 'safe'],
            [['age_y', 'age_m', 'dc'], 'integer'],
            [['pid', 'hoscode', 'hosname', 'hn', 'pname', 'fname', 'lname', 'occupat', 'pic', 'prov', 'amp', 'tmb', 'moo', 'street', 'place', 'addr', 'tel', 'family', 'addr_note', 'symptom', 'dx', 'doctor', 'discharge_type', 'note', 'reporter', 'reporter_position', 'reporter_tel', 'created_by', 'updated_by', 'accepted_hoscode', 'accepted_hosname', 'accepted_note', 'accepted_reject_note'], 'string', 'max' => 255],
            [['cid'], 'string', 'max' => 13, 'min' => 13],
            [['gender', 'deleted_by', 'deleted_note'], 'string'],
            [['deleted_at'], 'safe'],
            [['gender', 'hn', 'hoscode', 'fname', 'lname', 'date_sick', 'date_visit'], 'required'],
            [['amp', 'tmb', 'moo', 'dx', 'reporter', 'reporter_tel', 'reporter_position'], 'required']
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->notifyMophByAmp($this->amp);
        }
    }

    public function notifyMophByAmp($amp) {
        try {
            return $this->sendMophNotification($this->buildMophNotificationMessages(), $this->getMophNotifyConfig($amp));
        } catch (\Throwable $e) {
            Yii::warning('MOPH Notify failed: ' . $e->getMessage(), __METHOD__);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getMophNotifyConfig($amp = null) {
        $config = Yii::$app->params['mophNotify'] ?? [];
        $amp = (string) ($amp === null ? $this->amp : $amp);
        $account = $config['accounts'][$amp] ?? null;

        return array_merge([
            'endpoint' => $config['endpoint'] ?? MyMoph::DEFAULT_ENDPOINT,
            'clientKey' => '',
            'secretKey' => '',
        ], $account ?? []);
    }

    public function buildMophNotificationMessages() {
        return [
            MyMoph::buttonFlexMessage(
                    'แจ้งเคสไข้เลือดออก',
                    $this->buildMophNotificationBody(),
                    'รายละเอียด',
                    self::MOPH_NOTIFY_DETAIL_URL
            ),
        ];
    }

    public function buildMophNotificationBody() {
        $fullName = trim((string) $this->pname . (string) $this->fname . ' ' . (string) $this->lname);

        return implode("\n", [
            'ชื่อ : ' . ($fullName === '' ? '-' : $fullName),
            'อายุ : ' . $this->buildMophAgeText(),
            'วันรับรักษา : ' . $this->emptyText($this->date_visit),
            'วินิจฉัย: ' . $this->emptyText($this->getDiagnosisNameForMophNotification()),
            'รักษาที่ : ' . $this->emptyText($this->hosname),
            'บ้านเลขที่ : ' . $this->emptyText($this->addr),
            'ถนน/ซอย : ' . $this->emptyText($this->street),
            'รร/สถานที่: ' . $this->emptyText($this->place),
            'หมู่ที่: ' . $this->emptyText($this->getMooNameForMophNotification()),
            'ตำบล: ' . $this->emptyText($this->getTambonNameForMophNotification()),
            'อำเภอ : ' . $this->emptyText($this->getAmphurNameForMophNotification()),
        ]);
    }

    public function getDiagnosisNameForMophNotification() {
        try {
            $diagnosis = $this->getCdx()->one();
            if ($diagnosis && !empty($diagnosis->name)) {
                return $diagnosis->name;
            }
        } catch (\Throwable $e) {
            Yii::warning('Diagnosis lookup failed for MOPH Notify: ' . $e->getMessage(), __METHOD__);
        }

        return $this->dx;
    }

    public function getTambonNameForMophNotification() {
        try {
            $tambon = $this->getCtmb()->one();
            if ($tambon && !empty($tambon->name)) {
                return $tambon->name;
            }
        } catch (\Throwable $e) {
            Yii::warning('Tambon lookup failed for MOPH Notify: ' . $e->getMessage(), __METHOD__);
        }

        return $this->tmb;
    }

    public function getAmphurNameForMophNotification() {
        try {
            $amphur = $this->getCamp()->one();
            if ($amphur && !empty($amphur->name)) {
                return $amphur->name;
            }
        } catch (\Throwable $e) {
            Yii::warning('Amphur lookup failed for MOPH Notify: ' . $e->getMessage(), __METHOD__);
        }

        return $this->amp;
    }

    public function getMooNameForMophNotification() {
        try {
            $moo = $this->getCmoo()->one();
            if ($moo && !empty($moo->name)) {
                $mooCode = (string) $this->moo;
                $mooNo = strlen($mooCode) >= 8 ? substr($mooCode, 6, 2) : $mooCode;

                return $mooNo . '-' . $moo->name;
            }
        } catch (\Throwable $e) {
            Yii::warning('Moo lookup failed for MOPH Notify: ' . $e->getMessage(), __METHOD__);
        }

        return $this->moo;
    }

    private function buildMophAgeText() {
        $ageY = $this->hasAttribute('age_y') ? $this->age_y : null;
        $ageM = $this->hasAttribute('age_m') ? $this->age_m : null;

        return $this->emptyText($ageY) . 'ปี ' . $this->emptyText($ageM) . ' ด';
    }

    protected function sendMophNotification($messages, $config = []) {
        return MyMoph::send($messages, $config);
    }

    private function emptyText($value) {
        return empty($value) ? '-' : $value;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => '#',
            'pid' => 'Pid',
            'hoscode' => 'รหัสหน่วยงาน5หลัก',
            'hosname' => 'โรงพยาบาล',
            'hn' => 'เลขประจำตัวผู้ป่วย(HN)',
            'cid' => 'เลขบัตรประชาชน',
            'pname' => 'คำนำหน้า',
            'fname' => 'ชื่อ',
            'lname' => 'นามสกุล',
            'gender' => 'เพศ',
            'birth_date' => 'วันเกิด',
            'age_y' => 'อายุ(ปี)',
            'age_m' => 'เดือน',
            'occupat' => 'อาชีพ',
            'pic' => 'รูป',
            'prov' => 'จังหวัด',
            'amp' => 'อำเภอ',
            'tmb' => 'ตำบล',
            'moo' => 'หมู่/ชุมชน',
            'street' => 'ถนน/ซอย',
            'place' => 'โรงเรียน/ชุมชน/ที่ทำงาน',
            'addr' => 'บ้านเลขที่',
            'tel' => 'เบอร์ติดต่อผู้ป่วย',
            'family' => 'ข้อมูลติดต่อญาติผู้ป่วย',
            'addr_note' => 'หมายเหตุ',
            'date_sick' => 'วันเริ่มป่วย',
            'date_visit' => 'วันรับรักษา',
            'symptom' => 'อาการ(SYMPTOM)',
            'dx' => 'การวินิจฉัย',
            'date_dx' => 'วันที่วินิจฉัย',
            'doctor' => 'แพทย์',
            'lab' => 'ผลตรวจทางห้องปฏิบัติการ(Lab)',
            'discharge_type' => 'ประเภทการจำหน่าย',
            'date_discharge' => 'วันที่จำหน่าย',
            'note' => 'หมายเหตุ',
            'reporter' => 'ชื่อ-นามสกุล',
            'reporter_position' => 'ตำแหน่ง',
            'reporter_tel' => 'เบอร์ติดต่อ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'accepted_hoscode' => 'ผู้รับเคส',
            'accepted_hosname' => 'ผู้รับเคส',
            'accepted_at' => 'วันที่รับ',
            'accepted_note' => 'หมายเหตุ',
            'accepted_reject_at' => 'วันที่ยกเลิกรับเคส',
            'accepted_reject_note' => 'เหตุผลการยกเลิกรับเคส',
            'dc' => 'สอบสวน/ควบคุม',
            'deleted_note' => 'เหตุผล :',
        ];
    }
    public function getCdx() {
        return $this->hasOne(Cdx::class, ['code' => 'dx']);
    }

    public function getCamp() {
        return $this->hasOne(Camp::class, ['code' => 'amp']);
    }

    public function getCtmb() {
        return $this->hasOne(Ctmb::class, ['code' => 'tmb']);
    }

    public function getCmoo() {
        return $this->hasOne(Cmoo::class, ['code' => 'moo']);
    }

    public function getCoccupat() {
        return $this->hasOne(Coccupat::class, ['code' => 'occupat']);
    }

}
