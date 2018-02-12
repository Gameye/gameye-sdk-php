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

    public function testStartMatch()
    {
        $client = $this->createTestClientMock();
    }

    public function testStopMatch()
    {
        $client = $this->createTestClientMock();
    }

    public function testGetGames()
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
            '100' => (object) ['locationKey' => '100', 'name' => 'Local'],
        ], $client->GetLocations('test'));
    }

    public function testGetActiveMatches()
    {
        $client = $this->createTestClientMock();
    }

    public function testGetTemplates()
    {
        $client = $this->createTestClientMock();
    }

    public function testGetMatch()
    {
        $client = $this->createTestClientMock();
    }

    public function testGetMatchStatistic()
    {
        $client = $this->createTestClientMock();
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
