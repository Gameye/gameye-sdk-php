<?php

namespace Gameye\Test;

use Gameye\SDK\GameyeClient;

/*
This class mocks the Gameye client so that it may be unit tested
*/
class GameyeClientMock extends GameyeClient
{
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
}
