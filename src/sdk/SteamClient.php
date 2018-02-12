<?php

namespace Gameye\SDK;

final class SteamClient
{
    private $config;
    public $GameServersService;

    public function __construct($config)
    {
        $defaultConfig = [
            'WebToken' => getenv('STEAM_WEB_TOKEN'),
        ];

        $this->config = array_merge($defaultConfig, $config);
        $this->CheckConfigSet('WebToken');
        $client = new \Zyberspace\SteamWebApi\Client($this->config['WebToken']);
        $this->GameServersService = new \Zyberspace\SteamWebApi\Interfaces\IGameServersService($client);
    }

    private function CheckConfigSet($key)
    {
        if (!isset($this->config[$key]) || $this->config[$key] == '') {
            throw new \InvalidArgumentException(sprintf(
                'please provide a value for "%s" in config',
                $key
            ));
        }
    }
}
