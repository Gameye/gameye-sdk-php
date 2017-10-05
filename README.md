![Gameye](https://dev.gameye.com/img/logo_blue.png)

# Gameye SDK for PHP #

[![Build Status](https://img.shields.io/travis/Gameye/gameye-sdk-php.svg?style=flat)](https://travis-ci.org/Gameye/gameye-sdk-php)
[![Latest Stable Version](https://poser.pugx.org/Gameye/gameye-sdk-php/v/stable)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![Total Downloads](https://poser.pugx.org/Gameye/gameye-sdk-php/downloads)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![License](https://poser.pugx.org/gameye/gameye-sdk-php/license)](https://packagist.org/packages/gameye/gameye-sdk-php)

Create eSport and competitive matches for Counter-Strike: Global Offensive, Team Fortress 2, Left 4 Dead 2 and Killing Floor 2 for your platform without fixed monthly costs or any need for your own server infrastructure. Simply implement the Gameye API to kick off online matches when you need the, - you will even be able to implement the scores/statistics directly on your website. How cool is that!

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
            "gameye/gameye-sdk-php": "1.*"
        }
    }

You may also git checkout or [download all the files](https://github.com/Gameye/gameye-sdk-php/archive/master.zip), and include the Gameye SDK client manually.

## Getting started ##

1. Use the Gameye SDK to create a match with your desired game-specific options. It's important to specify an unique ID in order to be able to retrieve the details when the match has been created.

2. After the first player has joined the match, the status will change from `waiting` to `playing`. At this point it will be possible to retrieve statistics and scores from the match.

3. After the match has ended our platform will post a request to your webhook to let you know the match is done.


Initialize the Gameye API client and set your API key.

```php
$gameye = new \Gameye\SDK\createGameyeClient([
            'AccessToken' => 'yourgameyeapitoken',
            'ApiEndpoint' => 'https://api.gameye.com',
        ]);
```

Create a match.

```php
$gameye->StartMatch([
    'matchId'     => 'yourmatchid',
    'locationIds' => [1],
    'gameId'      => 1,
    'templateId'  => 20,
    'config'      => [
        'sv_setsteamaccount' => 'yoursteamgameservertoken',
        'maxplayers'         => 12,
        'tickrate'           => 128,
        'mapgroup'           => 'mg_active',
        'map'                => 'de_dust2',
    ]
]);
```

_After creating the match, the match details will be available via the `GetMatchState` function._

Get a list of all available games we support.

```php
$gameye->GetGames();
```

Get a list of all locations where a game is available.

```php
$gameye->GetLocations($gameid);
```

Get a list of all available templates (configuration files) for a game.

```php
$gameye->GetTemplates($gameid);
```
Get a list of all your active matches.

```php
$gameye->GetActiveMatches($gameid);
```

Get the server details of a match.

```php
$gameye->GetMatch($matchid);
```

Get the result (scores and statistics) of a match.

```php
$gameye->GetMatchResult($matchid);
```

Stop a match.

```php
$gameye->StopMatch($matchid);
```

## Create a Steam Server Login Token ##

We made a helper function to make it easier for you to create a GSLT (Game Server Login Token) via the Steam WEB API. It is strongly recommended to create a fresh token for every match and delete the token after the match has ended. This is advisable because every Steam account is limited to a maximum of 1000 tokens. Passing a GSLT when starting a match is currently only required for CS:GO. For more information see the [Steam website](https://steamcommunity.com/dev/managegameservers).

```php
$steam = new \Gameye\SDK\SteamClient([
            'WebToken' => 'webtoken',
        ]);

$steam->GameServersService->CreateAccountV1 ($appid, $memo);
```
You can create a Steam Web API key on the [Steam website](https://steamcommunity.com/dev/apikey).

List of APP ids that can be used:

CS:G0 = 730  
CSS = 240  
TF2 = 440  
L4D2 = 550  
KF2 = 232090

## Examples ##

We have created an example implementation of this SDK based on the Laravel framework which implements all functions provided here, this should show you how to create a basic backend and how to create and manage matches via our API.

+ [Example implementation in Laravel](https://github.com/Gameye/gameye-sdk-example-laravel).

## Contributing ##
We encourage everyone to help us improve our public packages. If you want to contribute please submit a [pull request](https://github.com/Gameye/gameye-sdk-php/pulls).

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php). 2017 Gameye B.V.

## Support ##
Contact: [gameye.com](https://gameye.com) — support@gameye.com
