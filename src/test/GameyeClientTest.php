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

    public function testDoStartMatch()
    {
        $client = $this->createTestClientMock();
        // TODO: implement me!
    }

    public function testDoStopMatch()
    {
        $client = $this->createTestClientMock();
        // TODO: implement me!
    }

    public function testFetchGames()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals([
            'csgo' => (object) ['gameKey' => 'csgo', 'name' => 'csgo'],
            'tf2'  => (object) ['gameKey' => 'tf2',  'name' => 'tf2' ],
            'css'  => (object) ['gameKey' => 'css',  'name' => 'css' ],
            'l4d2' => (object) ['gameKey' => 'l4d2', 'name' => 'l4d2'],
            'kf2'  => (object) ['gameKey' => 'kf2',  'name' => 'kf2' ],
            'test' => (object) ['gameKey' => 'test', 'name' => 'test'],
        ], $client->GetGames());
    }

    public function testGetLocations()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals([
            100 => (object) ['locationKey' => 100, 'name' => 'Local'],
        ], $client->GetLocations('test'));
    }

    public function testGetActiveMatches()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals([
            'test-match-123' => (object) [
                "gameKey" => 'test-game',
                "host"=> "127.0.0.1",
                "locationKey"=> 100,
                "matchKey"=> "test-match-123",
                "port"=> (object) [
                    "game"=> 57015,
                    "tv"=> 57025
                ],
                "created"=> new \DateTime('2018-02-09T15:48:58Z'),
            ],
        ], $client->GetActiveMatches('test-game'));
    }

    public function testGetTemplates()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals([
            "t1" => (object) [
                'templateKey' => 't1',
                'name' => 't1',
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
                'name' => 't2',
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
        ], $client->GetTemplates('game-123'));
    }

    public function testGetMatch()
    {
        $client = $this->createTestClientMock();
        $this->assertEquals((object) [
            "gameKey" => 'testing',
            "host"=> "127.0.0.1",
            "locationKey"=> 100,
            "matchKey"=> "test-match-456",
            "port"=> (object) [
                "game"=> 67015,
                "tv"=> 67025
            ],
            "created"=> new \DateTime('2018-02-09T15:48:59Z'),
        ], $client->GetMatch('test-match-456'));
    }

    public function testGetMatchStatistic()
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
