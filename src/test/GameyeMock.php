<?php

namespace Gameye\Test;

final class GameyeMock
{
    private function __construct()
    {
    }

    public function mockGame()
    {
        return json_decode('
{
    "game": {
        "csgo": { "gameKey": "csgo", "location": {} },
        "tf2": { "gameKey": "tf2", "location": {} },
        "css": { "gameKey": "css", "location": {} },
        "l4d2": { "gameKey": "l4d2", "location": {} },
        "kf2": { "gameKey": "kf2", "location": {} },
        "test": { "gameKey": "test", "location": { "local": true } }
    },
    "location": {
        "rotterdam": { "locationKey": "rotterdam" },
        "ireland": { "locationKey": "ireland" },
        "dubai": { "locationKey": "dubai" },
        "tokyo": { "locationKey": "tokyo" },
        "los_angeles": { "locationKey": "los_angeles" },
        "washington_dc": { "locationKey": "washington_dc" },
        "local": { "locationKey": "local" }
    }
}
');
    }

    public function mockMatch()
    {
        return json_decode('
{
    "match": {
        "test-match-123": {
            "created": 1518191338368,
            "gameKey": "test",
            "host": "127.0.0.1",
            "locationKey": "local",
            "matchKey": "test-match-123",
            "port": {
                "game": 57015,
                "tv": 57025
            }
        },
        "test-match-456": {
            "created": 1518191339368,
            "gameKey": "testing",
            "host": "127.0.0.1",
            "locationKey": "local",
            "matchKey": "test-match-456",
            "port": {
                "game": 67015,
                "tv": 67025
            }
        }
    }
}
');
    }

    public function mockTemplate()
    {
        return json_decode('
{
    "template": {
        "t1": {
            "templateKey": "t1",
            "arg": [{
                "name": "tickRate",
                "type": "number",
                "defaultValue": 64,
                "option": [64, 128]
            }]
        },
        "t2": {
            "templateKey": "t2",
            "arg": [{
                "name": "steamToken",
                "type": "string",
                "defaultValue": ""
            }, {
                "name": "hostname",
                "type": "string",
                "defaultValue": "gameye.com Match Server"
            }]
        }
    }
}
');
    }
}
