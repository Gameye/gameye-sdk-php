<?php

namespace Gameye\SDK;

function createGameyeClient($config)
{
    return new GameyeClient($config);
}

function createSteamClient($config)
{
    return new SteamClient($config);
}
