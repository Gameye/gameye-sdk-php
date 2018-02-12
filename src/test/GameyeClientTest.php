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
    }

    public function testGetLocations()
    {
        $client = $this->createTestClientMock();
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
