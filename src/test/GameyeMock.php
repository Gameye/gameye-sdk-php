<?php

namespace Gameye\Test;

final class GameyeMock
{
    private function __construct()
    {
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

    public function mockStatistic()
    {
        return json_decode('
{
    "start": 1519833365000,
    "stop": 1519834524000,
    "player": {
        "3": {
            "playerKey": "3",
            "connected": false,
            "uid": "STEAM_1:1:218909830",
            "name": "denise",
            "statistic": {
                "assist": 0,
                "death": 19,
                "kill": 17
            }
        },
        "4": {
            "playerKey": "4",
            "connected": false,
            "uid": "STEAM_1:1:24748064",
            "name": "Smashmint",
            "statistic": {
                "assist": 0,
                "death": 17,
                "kill": 19
            }
        }
    },
    "startedRounds": 36,
    "finishedRounds": 36,
    "team": {
        "1": {
            "teamKey": "1",
            "name": "TeamA",
            "statistic": {
                "score": 17
            },
            "player": {
                "3": true
            }
        },
        "2": {
            "teamKey": "2",
            "name": "TeamB",
            "statistic": {
                "score": 19
            },
            "player": {
                "4": true
            }
        }
    }
}
');
    }
}
