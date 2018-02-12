<?php

namespace Gameye\SDK;

class GameyeClient
{
    private $config;
    private $httpClient;

    public function __construct($config)
    {
        $defaultConfig = [
            'ApiEndpoint' => getenv('GAMEYE_API_ENDPOINT'),
            'AccessToken' => getenv('GAMEYE_API_TOKEN'),
        ];
        $this->config = array_merge($defaultConfig, $config);

        $this->CheckConfigSet('ApiEndpoint');
        $this->CheckConfigSet('AccessToken');
    }

    //TODO: description of function
    public function StartMatch($matchKey, $locationKeys, $gameKey, $templateKey, $config)
    {
        // TODO: check argument types
        // $matchKey: string
        // $locationKeys: number[]
        // $gameKey: string
        // $templateKey: string
        // $config: object
        
        $payload = (object) [
            'matchKey'    => $matchKey,
            'locationKeys'=> $locationKeys,
            'gameKey'     => $gameKey,
            'templateKey' => $templateKey,
            'config'      => $config,
        ];
        $this->PerformAction('start-match', $payload);
    }

    //TODO: description of function
    public function StopMatch($matchKey)
    {
        // TODO: check argument types
        // $matchKey: string

        $payload = [
            'matchKey' => $matchKey,
        ];
        $this->PerformAction('stop-match', $payload);
    }

    //TODO: description of function
    public function GetGames()
    {
        $state = $this->FetchState('game', []);

        $result = [];

        foreach ($state->game as $gameKey => $gameItem) {
            $result[$gameKey] = (object) [
                'gameKey' => $gameKey,
                'name'   => $gameItem->gameKey,
            ];
        }

        return $result;
    }

    //TODO: description of function
    public function GetLocations($gameKey)
    {
        // TODO: check argument types
        // $gameKey: string

        $state = $this->FetchState('location', []);
        $result = [];
        foreach ($state->game->$gameKey->location as $locationKey) {
            $locationItem = $state->location->$locationKey;
            $result[$locationKey] = (object) [
                'locationKey' => $locationKey,
                'name'       => $locationItem->name,
            ];
        }

        return $result;
    }

    //TODO: description of function
    public function GetActiveMatches($gameKey)
    {
        // TODO: check argument types
        // $gameKey: string

        $state = $this->FetchState('match', []);

        $result = [];

        foreach ($state->match as $matchKey => $matchItem) {
            if ($matchItem->gameKey != $gameKey) {
                continue;
            }

            $result[$matchKey] = (object) [
                'matchKey'    => $matchKey,
                'gameKey'     => $matchItem->gameKey,
                'locationKey' => $matchItem->locationKey,
                'created'    => \DateTime::createFromFormat('U', $matchItem->created / 1000),
            ];
        }

        return $result;
    }

    //TODO: description of function
    public function GetTemplates($gameKey)
    {
        // TODO: check argument types
        // $gameKey: string

        $state = $this->FetchState('template', [$gameKey]);

        $result = [];

        foreach ($state->game->$gameKey->template as $templateKey => $templateItem) {
            $result[$templateKey] = (object) [
                'templateKey' => $templateKey,
                'name'       => $templateItem->name,
            ];
        }

        return $result;
    }

    //TODO: description of function
    public function GetMatch($matchKey)
    {
        // TODO: check argument types
        // $matchKey: string

        $state = $this->FetchState('match');

        $matchItem = $state->match->$matchKey;

        $result = (object) [
            'matchKey'     => $matchKey,
            'gameKey'      => $matchItem->gameKey,
            'locationKey'  => $matchItem->locationKey,
            'created'     => \DateTime::createFromFormat('U', $matchItem->created / 1000),
            'host'        => $matchItem->host,
            'portMapping' => $matchItem->portMapping,
        ];

        return $result;
    }

    //TODO: description of function
    public function GetMatchStatistic($matchKey, $statisticKey)
    {
        // TODO: check argument types
        // $matchKey: string
        // $statisticKey: string

        $state = $this->FetchState('statistic', [$matchKey]);

        $statItem = $state->match->$matchKey;

        $result = $statItem;

        return $result;
    }

    protected function FetchState($state, $args)
    {
        $client = new \GuzzleHttp\Client();

        $url = $this->MakeFetchUrl($state, $args);
        $headers = [
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $request = new \GuzzleHttp\Psr7\Request('GET', $url, $headers);

        $response = $client->send($request);
        this.CheckResponse($response);

        return json_decode($response->getBody());
    }

    protected function PerformAction($action, $body)
    {
        $client = new \GuzzleHttp\Client();

        $url = $this->MakeActionUrl($action);
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $body = json_encode($body);
        $request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, $body);

        $response = $client->send($request);
        this.CheckResponse($response);
    }

    private function CheckResponse($response)
    {
        // TODO: if response error (check status) then throw error with
        // $response->getBody() text
    }

    private function MakeFetchUrl($state, $args)
    {
        $url = sprintf('%s/fetch/%s/%s', $this->config['ApiEndpoint'], $state, implode('/', $args));

        return $url;
    }

    private function MakeActionUrl($action)
    {
        $url = sprintf('%s/action/%s', $this->config['ApiEndpoint'], $action);

        return $url;
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
