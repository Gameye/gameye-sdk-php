# Gameye SDK for PHP #

[![Latest Stable Version](https://poser.pugx.org/Gameye/gameye-sdk-php/v/stable)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![Total Downloads](https://poser.pugx.org/Gameye/gameye-sdk-php/downloads)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![License](https://poser.pugx.org/gameye/gameye-sdk-php/license)](https://packagist.org/packages/gameye/gameye-sdk-php)

Create eSport and competitive matches for Counter-Strike: Global Offensive, Team Fortress 2, Left 4 Dead 2, Killing Floor 2, Insurgency and Day of Infamy for your platform without fixed monthly costs or any need for your own server infrastructure. Simply implement the Gameye API to kick off online matches when you need the, - you will even be able to implement the scores/statistics directly on your website. How cool is that!

## Requirements ##

To use the Gameye SDK, the following prerequisites need to be fulfilled:

+ Obtain a free Gameye API key, please send us [an email](mailto:support@gameye.com)
+ Composer
+ PHP 5.6.4+ or newer
+ PHP cURL extension

## Installation ##

The easiest way to install the Gameye SDK is to require it with [Composer](http://getcomposer.org/doc/00-intro.md).

    $ composer require gameye/gameye-sdk-php

    {
        "require": {
            "gameye/gameye-sdk-php": "2.*"
        }
    }

You may also git checkout or [download all the files](https://github.com/Gameye/gameye-sdk-php/archive/master.zip), and include the Gameye SDK client manually.

## Getting started ##

To play around with the API, we recommend a REST client called Postman. Simply tap the button below to import a pre-made collection of examples.

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5b09c19acdd27530e455)

1. Use the Gameye SDK to create a match with your desired game-specific options. It's important to specify an unique ID in order to be able to retrieve the details when the match has been created.

2. After the match has ended we will fire a GET request to your webhook to let you know the match is done.

Initialize the Gameye API client and set your API key.

```php
$gameye = new \Gameye\SDK\GameyeClient([
            'AccessToken' => 'yourgameyeapitoken',
            'ApiEndpoint' => 'https://api.gameye.com',
        ]);
```

Create a match.

```php
$gameye->commandStartMatch([
    'matchKey'     => 'yourmatchid',
    'locationKeys' => ['rotterdam', 'ireland'],
    'gameKey'      => 'csgo',
    'templateKey'  => 'esl1on1',
    'config'       => [
        'steamToken'  => 'yoursteamgameservertoken',
        'maxPlayers'  => 12,
        'maxRounds'   => 15,
        'tickRate'    => 128,
        'map'         => 'de_dust2',
        'mapgroup'     => 'mg_active',
        'teamNameOne' => 'Counter Terrorists',
        'teamNameTwo' => 'Terrorists'
    ],
    'endCallbackUrl' => 'https://platform.com/match?id=yourmatchid'
]);
```

_After creating the match, the server details will be available via the `queryMatch` function._
_When the match has been ended we will make a GET request to your callback url so you can fetch the match results._

Create a match with a custom (Steam Workshop) map.  
Remove the map parameter from the config array and add the following two parameters.  


```php
'config' => [
    'workshopMap' => 'workshopid',
    'authkey'     => 'yoursteamwebapikey'
],
```
You can find the id of a custom map at the end of a [Steam Workshop URL](https://steamcommunity.com/workshop/browse/?appid=730).

Get a list of all available games and locations we support.
```php
$gameye->queryGame();
```

Get a list of all available templates (configuration files) for a game.
```php
$gameye->queryTemplate($gameKey);
```

Get a detailed list of all your active matches.
```php
$gameye->queryMatch();
```

Stop a match.
```php
$gameye->commandStopMatch([
    'matchKey' => $matchKey,
]);
```

## Match results ##

When the match has been ended you can fetch the game scores and other statistics. You can pass a webhook URL when to create a match to get a notification when a match is done.

The following statistics are currently available for CS:GO

Match statistics:
- time started
- time ended
- rounds played

Team statistics:
- name
- score
- players

Player statistics:
- nickname
- steam id
- kills
- assists
- deaths

First, import the Gameye Selector class.

```php
use \Gameye\SDK\GameyeSelector;
```

Get the statistic state of a match.

```php
$match = $gameye->queryStatistic($matchKey);
```

Get the teams that participated in a match.

```php
GameyeSelector::selectTeamList($match);
```

Get a single team.

```php
GameyeSelector::selectTeamItem($match, $teamKey);
```

Get all the players that participated in a match.

```php
GameyeSelector::selectPlayerList($match);
```
Note: we only show players that were connected to the match when it ended. For example if a player leaves in the last round of a match, he won't included in the statistics.

Get all players from a team.

```php
GameyeSelector::selectPlayerListForTeam($match, $teamKey);
```

## Create a Steam Server Login Token ##

We made a helper function to make it easier for you to create a GSLT (Game Server Login Token) via the Steam WEB API. It is strongly recommended to create a fresh token for every match and delete the token after the match has ended. This is advisable because every Steam account is limited to a maximum of 1000 tokens. Passing a GSLT when starting a match is currently only required for CS:GO. For more information see the [Steam website](https://steamcommunity.com/dev/managegameservers).

```php
$steam = new \Gameye\SDK\SteamClient([
            'WebToken' => 'webtoken',
        ]);

$steam->GameServersService->CreateAccountV1($appid, $memo);
```
You can create a Steam Web API key on the [Steam website](https://steamcommunity.com/dev/apikey).

The APP id that you should include for CS:GO is 730


## Examples ##

We have created an example implementation of this SDK based on the Laravel framework which implements all functions provided here, this should show you how to create a basic backend and how to create and manage matches via our API.

+ [Example implementation in Laravel](https://github.com/Gameye/gameye-sdk-example-laravel).

## Contributing ##
We encourage everyone to help us improve our public packages. If you want to contribute please submit a [pull request](https://github.com/Gameye/gameye-sdk-php/pulls).

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php). 2017 Gameye B.V.

## Support ##
Contact: [gameye.com](https://gameye.com) — support@gameye.com
