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
}
