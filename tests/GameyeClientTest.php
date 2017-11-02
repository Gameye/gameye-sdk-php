<?php

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
        $this->expectException(InvalidArgumentException::class);

        $gameyeClient = new GameyeClient([]);
    }
}
