<?php

namespace Gameye\SDK;

/**
 * Gameye API client
 */
class GameyeClient
{
    private $config;
    private $httpClient;

    /**
     * @param object $config
     * @param \GuzzleHttp\Client $httpClient
     */
    public function __construct(
        $config,
        $httpClient = null
    ) {
        $defaultConfig = [
            'ApiEndpoint' => getenv('GAMEYE_API_ENDPOINT'),
            'AccessToken' => getenv('GAMEYE_API_TOKEN'),
        ];
        $this->config = array_merge($defaultConfig, $config);

        $this->CheckConfigSet('ApiEndpoint');
        $this->CheckConfigSet('AccessToken');

        if (isset($httpClient)) {
            $this->httpClient = $httpClient;
        } else {
            $this->httpClient = new \GuzzleHttp\Client();
        }
    }

    /**
     * TODO: description of function
     * @param object $payload
     */
    public function DoStartMatch(
        $payload
    ) {
        $this->PerformAction('start-match', $payload);
    }

    /**
     * TODO: description of function
     * @param object $payload
     */
    public function DoStopMatch(
        $payload
    ) {
        $this->PerformAction('stop-match', $payload);
    }

    /**
     * TODO: description of function
     */
    public function GetGameState()
    {
        $state = $this->FetchState('game', []);

        return $state;
    }

    /**
     * TODO: description of function
     */
    public function GetMatchState()
    {
        $state = $this->FetchState('match', []);

        return $state;
    }

    /**
     * TODO: description of function
     * @param string $gameKey
     */
    public function GetTemplateState(
        $gameKey
    ) {
        $gameKey = (string)$gameKey;

        $state = $this->FetchState('template', [$gameKey]);

        return $state;
    }

    /**
     * TODO: description of function
     * @param string $matchKey
     * @param string $statisticKey
     */
    public function GetMatchStatistic(
        $matchKey,
        $statisticKey
    ) {
        $matchKey = (string)$matchKey;
        $statisticKey = (string)$statisticKey;

        $state = $this->FetchState('statistic', [$matchKey, $statisticKey]);

        return $state;
    }

    protected function FetchState(
        $state,
        $args
    ) {
        $url = $this->MakeFetchUrl($state, $args);
        $headers = [
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $request = new \GuzzleHttp\Psr7\Request('GET', $url, $headers);

        $response = $this->httpClient->send($request);
        this.CheckResponse($response);

        return json_decode($response->getBody());
    }

    protected function PerformAction(
        $action,
        $body
    ) {
        $url = $this->MakeActionUrl($action);
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $body = json_encode($body);
        $request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, $body);

        $response = $this->httpClient->send($request);
        this.CheckResponse($response);
    }

    private function CheckResponse(
        $response
    ) {
        if (!($this->statusCode >= 200 && $this->statusCode < 300)) {
            // if statucode is not in the 2xx range
            throw new Exception($response->getBody());
        }
    }

    private function MakeFetchUrl(
        $state,
        $args
    ) {
        $url = sprintf('%s/fetch/%s/%s', $this->config['ApiEndpoint'], $state, implode('/', $args));

        return $url;
    }

    private function MakeActionUrl(
        $action
    ) {
        $url = sprintf('%s/action/%s', $this->config['ApiEndpoint'], $action);

        return $url;
    }

    private function CheckConfigSet(
        $key
    ) {
        if (!isset($this->config[$key]) || $this->config[$key] == '') {
            throw new \InvalidArgumentException(sprintf(
                'please provide a value for "%s" in config',
                $key
            ));
        }
    }
}
