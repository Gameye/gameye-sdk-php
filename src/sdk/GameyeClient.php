<?php

namespace Gameye\SDK;

/**
 * Gameye API client.
 */
class GameyeClient
{
    private $config;
    private $httpClient;

    /**
     * @param object             $config
     * @param \GuzzleHttp\Client $httpClient
     */
    public function __construct(
        $config
    ) {
        $defaultConfig = [
            'ApiEndpoint' => getenv('GAMEYE_API_ENDPOINT'),
            'AccessToken' => getenv('GAMEYE_API_TOKEN'),
        ];
        $this->config = array_merge($defaultConfig, $config);

        $this->checkConfigSet('ApiEndpoint');
        $this->checkConfigSet('AccessToken');

        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * TODO: description of function.
     *
     * @param object $payload
     */
    public function commandStartMatch(
        $payload
    ) {
        $this->command('start-match', $payload);
    }

    /**
     * TODO: description of function.
     *
     * @param object $payload
     */
    public function commandStopMatch(
        $payload
    ) {
        $this->command('stop-match', $payload);
    }

    /**
     * TODO: description of function.
     *
     * @return object
     */
    public function queryGame()
    {
        $state = $this->query('game', []);

        return $state;
    }

    /**
     * TODO: description of function.
     *
     * @return object
     */
    public function queryMatch()
    {
        $state = $this->query('match', []);

        return $state;
    }

    /**
     * TODO: description of function.
     *
     * @param string $gameKey
     *
     * @return object
     */
    public function queryTemplate(
        $gameKey
    ) {
        $gameKey = (string) $gameKey;
        $state = $this->query(
            'template',
            [
                'gameKey'=> $gameKey,
            ]
        );

        return $state;
    }

    /**
     * TODO: description of function.
     *
     * @param string $matchKey
     * @param string $statisticKey
     *
     * @return object
     */
    public function queryStatistic(
        $matchKey
    ) {
        $matchKey = (string) $matchKey;

        $state = $this->query(
            'statistic',
            [
                'matchKey' => $matchKey,
            ]
        );

        return $state;
    }

    public function query(
        $state,
        $args
    ) {
        $url = $this->makeQueryUrl($state, $args);
        $headers = [
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $request = new \GuzzleHttp\Psr7\Request('GET', $url, $headers);

        $response = $this->httpClient->send($request);
        $this->CheckResponse($response);

        return json_decode($response->getBody());
    }

    public function command(
        $action,
        $body
    ) {
        $url = $this->makeCommandUrl($action);
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => sprintf('Bearer %s', $this->config['AccessToken']),
        ];
        $body = json_encode($body);
        $request = new \GuzzleHttp\Psr7\Request('POST', $url, $headers, $body);

        $response = $this->httpClient->send($request);
        $this->CheckResponse($response);
    }

    private function makeQueryUrl(
        $state,
        $args
    ) {
        $query = http_build_query($args);
        if (len($query) > 0) {
            $query = "?" . $query;
        }

        $url = sprintf('%s/fetch/%s%s', $this->config['ApiEndpoint'], $state, $query);

        return $url;
    }

    private function makeCommandUrl(
        $action
    ) {
        $url = sprintf('%s/action/%s', $this->config['ApiEndpoint'], $action);

        return $url;
    }

    private function checkResponse(
        $response
    ) {
        $statusCode = $response->getStatusCode();
        if (!($statusCode >= 200 && $statusCode < 300)) {
            // if statucode is not in the 2xx range
            throw new \Exception($response->getBody());
        }
    }

    private function checkConfigSet(
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
