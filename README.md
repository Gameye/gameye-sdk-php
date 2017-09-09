![Gameye](https://dev.gameye.com/img/logo_blue.png)

# Gameye SDK for PHP #

[![Build Status](https://img.shields.io/travis/Gameye/gameye-sdk-php.svg?style=flat)](https://travis-ci.org/Gameye/gameye-sdk-php)
[![Latest Stable Version](https://poser.pugx.org/Gameye/gameye-sdk-php/v/stable)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![Total Downloads](https://poser.pugx.org/Gameye/gameye-sdk-php/downloads)](https://packagist.org/packages/gameye/gameye-sdk-php)
[![License](https://poser.pugx.org/gameye/gameye-sdk-php/license)](https://packagist.org/packages/gameye/gameye-sdk-php)

Create eSport and competitive matches for Counter-Strike: Global Offensive, Team Fortress 2, Left 4 Dead 2 and Killing Floor 2 for your platform without fixed monthly costs or any need for server infrastructure. Just use the Gameye API to run online matches and retrieve the scores/statistics directly on your website.

## Requirements ##

To use the Gameye SDK, the following things are required:

+ Get a free Gameye API key, please send us [an email](mailto:support@gameye.com)
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

1. Use the Gameye SDK to create match with the game options you want. It's important to specifiy an unique ID to be able to retreive the details when the match has been created.

2. After the first player has joined the match, the status will change from `waiting` to `playing`. At this point it's possible to get statistics en scores from the match.

3. The match has ended and our platform will send a request to your webhook to let you know the match is done.


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

_After creating the match, the match details are available via the `GetMatchState` function._

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
$gameye->GetActiveMatches();
```

Get the server details of a match.

```php
$gameye->GetMatch($matchid);
```

Get the result (scores and statistics) of a match.

```php
$gameye->GetMatchResults($matchid);
```

Stop a match.

```php
$gameye->StopMatch($matchid);
```

## Create a Steam Server Login Token ## 

We made a helper function to make it easier fro you to create GSLT (Game Server Login Token) via the Steam WEB API. It's recommended that you create a new token for every new match and delete the token after the match has been ended. This because a Steam account is limited to max 1000 tokens. Passing a GSLT when starting a match is currently only needed for CS:GO. For more information see the [Steam website](https://steamcommunity.com/dev/managegameservers).

```php
$steam = new \Gameye\SDK\createSteamClient([
            'webToken' => 'webtoken',
        ]);

$steam->GameServersService->CreateAccountV1 ($appid, $memo);
```
You can create a Steam Web API key on the [Steam website](https://steamcommunity.com/dev/apikey).

List of APP id's you can use:

CS:G0 = 730  
CSS = 240  
TF2 = 440  
L4D2 = 550  
KF2 = 232090

## Examples ##

We have made an example implementation based on the Laravel framework which uses all functions of this SDK, it shows you have to create a basic backend how to create and manage matches via our API. 

+ [Example implementation in Laravel](https://github.com/Gameye/gameye-sdk-example-laravel).

## Contributing ##
We encourage everyone to help us better our public packages. If you want to contribute please submit a [pull request](https://github.com/Gameye/gameye-sdk-php/pulls).

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php). 2017 Gameye B.V.

## Support ##
Contact: [gameye.com](https://gameye.com) — support@gameye.com
