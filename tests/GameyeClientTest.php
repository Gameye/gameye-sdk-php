<?php

use PHPUnit\Framework\TestCase;
use Gameye\SDK\GameyeClient;

/**
 * @covers Gameye\SDK\GameyeClient
 */
final class GameyeClientTest extends TestCase
{
    public function testCreateApiClient()
    {
        $gameyeClient = new GameyeClient(array(
            "ApiEndpoint" => "https://api.gameye.com",
            "AccessToken" => "supersecret",
        ));
        
        $this->assertInstanceOf(
            GameyeClient::class,
            $gameyeClient
        );
    }

    public function testCreateApiClientMissingAccessToken()
    {
        $this->expectException(InvalidArgumentException::class);

        $gameyeClient = new GameyeClient(array());
    }
}
