<?php

namespace Gameye\SDK;

final class GameyeClient
{
    private $config;
    private $httpClient;

    public function __construct($config)
    {
        $defaultConfig = [
            'ApiEndpoint' => getenv("GAMEYE_API_ENDPOINT"),
            'AccessToken' => getenv("GAMEYE_API_TOKEN"),
        ];
        $this -> config = array_merge($defaultConfig, $config);
       
        $this -> CheckConfigSet('ApiEndpoint');
        $this -> CheckConfigSet('AccessToken');
    }

    public function StartMatch($matchId, $locationIds, $gameId, $templateId, $config)
    {
        $payload = (object) [
            "matchId" => $matchId,
            "locationIds" => $locationIds,
            "gameId" => $gameId,
            "templateId" => $templateId,
            "config" => $config,
        ];
        $this -> PerformAction("StartMatch", $payload);
    }
  
    public function StopMatch($matchId)
    {
        $payload = [
            "matchId" => $matchId,
        ];
        $this -> PerformAction("StopMatch", $payload);
    }
    
    public function GetGames()
    {
        $state = $this -> FetchState("Root", []);

        $result = [];

        foreach ($state -> game as $gameId => $gameItem) {
            $result[$gameId] = (object) [
                "gameId" => $gameId,
                "name" => $gameItem -> name,
            ];
        }

        return $result;
    }
    
    public function GetLocations($gameId)
    {
        $state = $this -> FetchState("Root", []);
        $result = [];
        foreach ($state -> game -> $gameId -> location as $locationId) {
            $locationItem = $state -> location -> $locationId;
            $result[$locationId] = (object) [
                "locationId" => $locationId,
                "name" => $locationItem -> name,
            ];
        }
        return $result;
    }
    
    public function GetActiveMatches($gameId)
    {
        $state = $this -> FetchState("Client", []);

        $result = [];

        foreach ($state -> match as $matchId => $matchItem) {
            if ($matchItem -> gameId != $gameId) {
                continue;
            }
            
            $result[$matchId] = (object) [
                "matchId" => $matchId,
                "gameId" => $matchItem -> gameId,
                "locationId" => $matchItem -> locationId,
                "created" => \DateTime::createFromFormat('U', $matchItem->created / 1000),
            ];
        }

        return $result;
    }
    
    public function GetTemplates($gameId)
    {
        $state = $this -> FetchState("Root", []);

        $result = [];
        
        foreach ($state -> game ->$gameId -> template as $templateId => $templateItem) {
            $result[$templateId] = (object) [
                "templateId" => $templateId,
                "name" => $templateItem -> name,
            ];
        }

        return $result;
    }

    public function GetMatch($matchId)
    {
        $state = $this -> FetchState("Match", [$matchId]);

        $matchItem = $state -> match -> $matchId;

        $result = (object) [
            "matchId" => $matchId,
            "gameId" => $matchItem -> gameId,
            "locationId" => $matchItem -> locationId,
            "created" => \DateTime::createFromFormat('U', $matchItem->created / 1000),
            "host" => $matchItem -> host,
            "portMapping" => $matchItem -> portMapping,
        ];
        
        return $result;
    }
    
    public function GetMatchResult($matchId)
    {
        $state = $this -> FetchState("Stat", [$matchId]);

        $statItem = $state -> match -> $matchId;
        
        $result = $statItem;
        
        return $result;
    }

    private function FetchState($state, $args)
    {
        $client = new \GuzzleHttp\Client();

        $url = $this -> MakeFetchUrl($state, $args);
        $headers = [
            'Authorization' => sprintf('Bearer %s', $this -> config["AccessToken"]),
        ];
        $request = new \GuzzleHttp\Psr7\Request('GET', $url, $headers);
        
        $response = $client -> send($request);
        
        return json_decode($response -> getBody());
    }

    private function PerformAction($action, $body)
    {
        $client = new \GuzzleHttp\Client();

        $url = $this -> MakeActionUrl($action);
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Bearer %s', $this -> config["AccessToken"]),
        ];
        $body = json_encode($body);
        $request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, $body);
        
        $response = $client -> send($request);
    }

    private function MakeFetchUrl($state, $args)
    {
        $url = sprintf('%s/fetch/%s/%s', $this -> config['ApiEndpoint'], $state, implode('/', $args));
        return $url;
    }

    private function MakeActionUrl($action)
    {
        $url = sprintf('%s/action/%s', $this -> config['ApiEndpoint'], $action);
        return $url;
    }

    private function CheckConfigSet($key)
    {
        if (!isset($this -> config[$key]) || $this -> config[$key] == '') {
            throw new \InvalidArgumentException(sprintf(
                'please provide a value for "%s" in config',
                $key
            ));
        }
    }
}
