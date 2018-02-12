<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeClient;
use PHPUnit\Framework\TestCase;

/**
 * @covers Gameye\SDK\GameyeClient
 */
final class GameyeClientTest extends TestCase
{
    public function testCreateApiClient()
    {
        $gameyeClient = new GameyeClient([
            'ApiEndpoint' => 'https://api.gameye.com',
            'AccessToken' => 'supersecret',
        ]);

        $this->assertInstanceOf(
            GameyeClient::class,
            $gameyeClient
        );
    }

    public function testCreateApiClientMissingAccessToken()
    {
        $this->expectException(\InvalidArgumentException::class);

        $gameyeClient = new GameyeClient([]);
    }

    public function testCommandStartMatch()
    {
        $client = $this->createTestClientMock();
        // TODO: implement me!
    }

    public function testCommandStopMatch()
    {
        $client = $this->createTestClientMock();
        // TODO: implement me!
    }

    public function testQueryGame()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals((object)[
            'game' => (object) [
                'csgo' => (object) ['gameKey' => 'csgo', 'location' => (object) [] ],
                'tf2'  => (object) ['gameKey' => 'tf2', 'location' => (object) [] ],
                'css'  => (object) ['gameKey' => 'css', 'location' => (object) [] ],
                'l4d2' => (object) ['gameKey' => 'l4d2', 'location' => (object) [] ],
                'kf2'  => (object) ['gameKey' => 'kf2', 'location' => (object) [] ],
                'test' => (object) ['gameKey' => 'test', 'location' => (object) [ '100' => true ] ],
            ],
            'location' => (object) [
                "1" => (object) [ "locationKey" => 1, "locationName" => "Rotterdam" ],
                "2" => (object) [ "locationKey" => 2, "locationName" => "Ireland" ],
                "3" => (object) [ "locationKey" => 3, "locationName" => "Dubai" ],
                "4" => (object) [ "locationKey" => 4, "locationName" => "Tokyo" ],
                "5" => (object) [ "locationKey" => 5, "locationName" => "Los Angeles" ],
                "6" => (object) [ "locationKey" => 6, "locationName" => "Washington DC" ],
                "100" => (object) [ "locationKey" => 100, "locationName" => "Local"],
            ]
        ], $client->queryGame());
    }

    public function testQueryMatch()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals((object)[
            "match" => (object)[
                "test-match-123" => (object)[
                    "created" => 1518191338368,
                    "gameKey" => "test-game",
                    "host" => "127.0.0.1",
                    "locationKey" => 100,
                    "matchKey" => "test-match-123",
                    "port" => (object)[
                        "game" => 57015,
                        "tv" => 57025
                    ]
                ],
                "test-match-456" => (object)[
                    "created" => 1518191339368,
                    "gameKey" => "testing",
                    "host" => "127.0.0.1",
                    "locationKey" => 100,
                    "matchKey" => "test-match-456",
                    "port" => (object)[
                        "game" => 67015,
                        "tv" => 67025
                    ]
                ]
            ]
        ], $client->queryMatch());
    }

    public function testQueryTemplate()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals((object)[
            "template" => (object) [
                "t1" => (object) [
                    'templateKey' => 't1',
                    'arg' => [
                        (object)[
                            "name"=> "tickRate",
                            "type"=> "number",
                            "defaultValue"=> 64,
                            "option"=> [64, 128]
                        ],
                    ],
                ],
                "t2"=> (object) [
                    'templateKey' => 't2',
                    'arg' => [
                        (object)[
                            "name"=> "steamToken",
                            "type"=> "string",
                            "defaultValue"=> "",
                        ],
                        (object)[
                            "name"=> "hostname",
                            "type"=> "string",
                            "defaultValue" => "gameye.com Match Server",
                        ],
                    ],
                ],
                ]
        ], $client->QueryTemplate('game-123'));
    }

    public function testQueryStatistic()
    {
        $client = $this->createTestClientMock();
        // TODO: implement me!
    }

    private function createTestClientMock()
    {
        $client = new GameyeClientMock([
            'ApiEndpoint' => 'https://api.gameye.com',
            'AccessToken' => 'supersecret',
        ]);

        return $client;
    }
}
