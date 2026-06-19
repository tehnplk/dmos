<?php

namespace tests\unit\components;

use app\components\MyMoph;

class MyMophTest extends \Codeception\Test\Unit
{
    public function testTextMessageCreatesLineTextPayload()
    {
        verify(MyMoph::textMessage('Hello MOPH'))->equals([
            'type' => 'text',
            'text' => 'Hello MOPH',
        ]);
    }

    public function testPayloadWrapsMessagesForMophNotify()
    {
        $message = MyMoph::textMessage('Hello MOPH');

        verify(MyMoph::payload([$message]))->equals([
            'messages' => [
                [
                    'type' => 'text',
                    'text' => 'Hello MOPH',
                ],
            ],
        ]);
    }

    public function testButtonFlexMessageCreatesUriButton()
    {
        $message = MyMoph::buttonFlexMessage(
            'แจ้งเตือน DMOS',
            "ชื่อผู้ป่วย\nรายละเอียด",
            'รายละเอียด',
            'http://dc.plkhealth.go.th/dmos/web/patient-hos/index?new=1'
        );

        verify($message['type'])->equals('flex');
        verify($message['altText'])->equals('แจ้งเตือน DMOS');
        verify($message['contents']['footer']['contents'][0]['action']['label'])->equals('รายละเอียด');
        verify($message['contents']['footer']['contents'][0]['action']['uri'])->equals('http://dc.plkhealth.go.th/dmos/web/patient-hos/index?new=1');
    }
}
