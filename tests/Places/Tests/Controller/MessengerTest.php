<?php

namespace Places\Tests\Controller;

use Places\Tests\WebTestCase;

class MessengerTest extends WebTestCase
{
    public function testChallengeWithInvalidMode()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/webhook/messenger', [
            'hub_mode' => 'foo',
        ]);

        $this->assertFalse($client->getResponse()->isOk());
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testChallengeWithInvalidVerifyToken()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/webhook/messenger', [
            'hub_mode' => 'subscribe',
            'hub_verify_token' => 'foo',
        ]);

        $this->assertFalse($client->getResponse()->isOk());
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testChallenge()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/webhook/messenger', [
            'hub_mode' => 'subscribe',
            'hub_verify_token' => 'dev_verify_token',
            'hub_challenge' => 'foo_challenge',
        ]);

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('foo_challenge', $client->getResponse()->getContent());
    }

    public function testAggreg()
    {
        $client = $this->createClient();
        $crawler = $client->request('POST', '/webhook/messenger', [], [], [], json_encode([
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
                        'text' => 'https://instagram.com/p/ABCDEFGH',
                    ],
                ]],
            ]],
        ]));

        $this->assertTrue($client->getResponse()->isOk());
    }
}
