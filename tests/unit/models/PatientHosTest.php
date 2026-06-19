<?php

namespace tests\unit\models;

use app\models\PatientHos;

class PatientHosTest extends \Codeception\Test\Unit
{
    private $oldMophNotifyConfig;

    protected function _before()
    {
        $this->oldMophNotifyConfig = \Yii::$app->params['mophNotify'] ?? null;
        \Yii::$app->params['mophNotify'] = [
            'endpoint' => 'https://example.test/api/notify/send',
            'accounts' => [
                '6501' => [
                    'clientKey' => 'client-6501',
                    'secretKey' => 'secret-6501',
                ],
                '6502' => [
                    'clientKey' => 'client-6502',
                    'secretKey' => 'secret-6502',
                ],
                '6509' => [
                    'clientKey' => 'client-6509',
                    'secretKey' => 'secret-6509',
                ],
                '6510' => [
                    'clientKey' => 'client-6510',
                    'secretKey' => 'secret-6510',
                ],
            ],
        ];
    }

    protected function _after()
    {
        if ($this->oldMophNotifyConfig === null) {
            unset(\Yii::$app->params['mophNotify']);
            return;
        }

        \Yii::$app->params['mophNotify'] = $this->oldMophNotifyConfig;
    }

    public function testAfterSaveSendsMophNotificationWhenAmpIs6502()
    {
        $model = new class([
            'amp' => '6502',
            'fname' => 'Somchai',
            'lname' => 'Test',
            'pname' => 'Mr.',
            'hn' => 'HN001',
            'hosname' => 'Test Hospital',
            'dx' => 'A90',
            'date_visit' => '2026-06-18',
            'age_y' => '10',
            'age_m' => '2',
            'addr' => '99/1',
            'street' => 'Test Road',
            'place' => 'Test School',
            'moo' => '65010100',
            'tmb' => '650201',
        ]) extends PatientHos {
            public $sentMessages = [];
            public $sentConfig = [];

            public function attributes()
            {
                return ['amp', 'pname', 'fname', 'lname', 'hn', 'hosname', 'dx', 'date_visit', 'age_y', 'age_m', 'addr', 'street', 'place', 'moo', 'tmb'];
            }

            public function getTambonNameForMophNotification()
            {
                return 'Wat Bot';
            }

            public function getAmphurNameForMophNotification()
            {
                return 'Wat Bot District';
            }

            public function getMooNameForMophNotification()
            {
                return '00-เทศบาล(นอกเขตชุมชน)';
            }

            public function getDiagnosisNameForMophNotification()
            {
                return 'Dengue fever';
            }

            protected function sendMophNotification($messages, $config = [])
            {
                $this->sentMessages = $messages;
                $this->sentConfig = $config;

                return [
                    'success' => true,
                ];
            }
        };

        $model->afterSave(true, []);

        verify(count($model->sentMessages))->equals(1);
        verify($model->sentMessages[0]['altText'])->equals('แจ้งเคสไข้เลือดออก');
        $bodyText = $model->sentMessages[0]['contents']['body']['contents'][0]['text'];
        verify($bodyText)->equals(implode("\n", [
            'ชื่อ : Mr.Somchai Test',
            'อายุ : 10ปี 2 ด',
            'วันรับรักษา : 2026-06-18',
            'วินิจฉัย: Dengue fever',
            'รักษาที่ : Test Hospital',
            'บ้านเลขที่ : 99/1',
            'ถนน/ซอย : Test Road',
            'รร/สถานที่: Test School',
            'หมู่ที่: 00-เทศบาล(นอกเขตชุมชน)',
            'ตำบล: Wat Bot',
            'อำเภอ : Wat Bot District',
        ]));
        $messageJson = json_encode($model->sentMessages[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        verify($messageJson)->stringContainsString('รายละเอียด');
        verify($messageJson)->stringContainsString('http://dc.plkhealth.go.th/dmos/web/patient-hos/index?new=1');
        verify($model->sentConfig['endpoint'])->equals('https://example.test/api/notify/send');
        verify($model->sentConfig['clientKey'])->equals('client-6502');
        verify($model->sentConfig['secretKey'])->equals('secret-6502');
    }

    public function testAfterSaveSendsMophNotificationForAnyAmpWithKeys()
    {
        $model = new class([
            'amp' => '6510',
            'fname' => 'Somchai',
            'lname' => 'Test',
            'hn' => 'HN001',
        ]) extends PatientHos {
            public $sentMessages = [];

            public function attributes()
            {
                return ['amp', 'pname', 'fname', 'lname', 'hn', 'hosname', 'dx', 'date_visit', 'addr', 'street', 'place', 'moo', 'tmb'];
            }

            protected function sendMophNotification($messages, $config = [])
            {
                $this->sentMessages = $messages;

                return [
                    'success' => true,
                ];
            }
        };

        $model->afterSave(true, []);

        verify(count($model->sentMessages))->equals(1);
    }

    public function testAfterSaveDoesNotSendMophNotificationOnUpdate()
    {
        $model = new class([
            'amp' => '6502',
            'fname' => 'Somchai',
            'lname' => 'Test',
            'hn' => 'HN001',
        ]) extends PatientHos {
            public $sentMessages = [];

            public function attributes()
            {
                return ['amp', 'pname', 'fname', 'lname', 'hn', 'hosname', 'dx', 'date_visit', 'addr', 'street', 'place', 'moo', 'tmb'];
            }

            protected function sendMophNotification($messages, $config = [])
            {
                $this->sentMessages = $messages;

                return [
                    'success' => true,
                ];
            }
        };

        $model->afterSave(false, ['amp' => '6501']);

        verify(count($model->sentMessages))->equals(0);
    }

    public function testMophNotifyConfigReturnsAmpSpecificKeys()
    {
        $model = new class(['amp' => '6509']) extends PatientHos {
            public function attributes()
            {
                return ['amp'];
            }
        };

        verify($model->getMophNotifyConfig()['clientKey'])->equals('client-6509');
        verify($model->getMophNotifyConfig()['secretKey'])->equals('secret-6509');
    }

    public function testNotifyMophByAmpUsesPassedAmpForKeys()
    {
        $model = new class([
            'amp' => '6502',
            'fname' => 'Somchai',
            'lname' => 'Test',
            'hn' => 'HN001',
        ]) extends PatientHos {
            public $sentConfig = [];

            public function attributes()
            {
                return ['amp', 'pname', 'fname', 'lname', 'hn', 'hosname', 'dx', 'date_visit', 'addr', 'street', 'place', 'moo', 'tmb'];
            }

            protected function sendMophNotification($messages, $config = [])
            {
                $this->sentConfig = $config;

                return [
                    'success' => true,
                ];
            }
        };

        $model->notifyMophByAmp('6509');

        verify($model->sentConfig['clientKey'])->equals('client-6509');
        verify($model->sentConfig['secretKey'])->equals('secret-6509');
    }

    public function testMophNotificationUsesAmphurNameFromMaster()
    {
        $model = new class extends PatientHos {
            public function getCamp()
            {
                return new class {
                    public function one()
                    {
                        return (object) [
                            'name' => 'Wat Bot District',
                        ];
                    }
                };
            }
        };

        verify($model->getAmphurNameForMophNotification())->equals('Wat Bot District');
    }

    public function testMophNotificationUsesMooNameFromMaster()
    {
        $model = new class(['moo' => '65010100']) extends PatientHos {
            public function attributes()
            {
                return ['moo'];
            }

            public function getCmoo()
            {
                return new class {
                    public function one()
                    {
                        return (object) [
                            'name' => 'เทศบาล(นอกเขตชุมชน)',
                        ];
                    }
                };
            }
        };

        verify($model->getMooNameForMophNotification())->equals('00-เทศบาล(นอกเขตชุมชน)');
    }

    public function testAttributeLabelsAreReadableThai()
    {
        $model = new class extends PatientHos {
            public function attributes()
            {
                return [];
            }
        };

        $labels = $model->attributeLabels();

        verify($labels['hoscode'])->equals('รหัสหน่วยงาน5หลัก');
        verify($labels['amp'])->equals('อำเภอ');
        verify($labels['date_visit'])->equals('วันรับรักษา');
        verify($labels['dx'])->equals('การวินิจฉัย');

        foreach ($labels as $label) {
            verify($label)->stringNotContainsString('เน€');
            verify($label)->stringNotContainsString('เธ');
        }
    }
}
