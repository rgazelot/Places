<?php

namespace Places\Tests\Messenger;

use Predis\Client as Redis;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

use Places\Messenger\Aggreg;

class AggregTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Places\Messenger\Exception\AggregException
     */
    public function testAggregWithInvalidBody()
    {
        $requestBody = new ParameterBag([
            'object' => 'page',
            'entry' => [[
                'id' => 'page_id',
                'time' => 1458692752478,
            ]],
        ]);

        $request = new Request;
        $request->request = $requestBody;

        $redis = $this->getMockBuilder(Redis::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['set'])
                     ->getMock();
        $redis->expects($this->never())
            ->method('set');

        $aggreg = new Aggreg($redis);
        $aggreg->aggreg($request);
    }

    /**
     * @dataProvider getShortCodes
     */
    public function testAggreg($urlShortCode, $shortCode)
    {
        $requestBody = new ParameterBag([
            'object' => 'page',
            'entry' => [[
                'id' => 'page_id',
                'time' => 1458692752478,
                'messaging' => [[
                    'sender' => [
                        'id' => 'sender_id',
                    ],
                    'recipient' => [
                        'id' => 'page_id',
                    ],
                    'timestamp' => 1458692752478,
                    'message' => [
                        'mid' => 'mid.1457764197618:41d102a3e1ae206a38',
                        'seq' => 42,
                        'text' => 'https://instagram.com/p/'.$urlShortCode,
                    ],
                ]],
            ]],
        ]);

        $request = new Request;
        $request->request = $requestBody;

        $redis = $this->getMockBuilder(Redis::class)
                     ->disableOriginalConstructor()
                     ->setMethods(['set'])
                     ->getMock();
        $redis->expects($this->once())
            ->method('set')
            ->with($shortCode, true);

        $aggreg = new Aggreg($redis);
        $aggreg->aggreg($request);
    }

    public function getShortCodes()
    {
        return [
            ['ABCD', 'ABCD'],
            ['ABCD/', 'ABCD'],
        ];
    }
}
