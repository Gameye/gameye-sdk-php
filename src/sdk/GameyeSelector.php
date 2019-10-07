<?php

namespace Gameye\SDK;

/**
 * Gameye API helper.
 */
final class GameyeSelector
{
    private function __construct()
    {
    }

    //region match

    /**
     * Select a list of active matches.
     *
     * @param object $matchState
     *
     * @return array
     */
    public static function selectMatchList(
        $matchState
    ) {
        $matchState = (object) $matchState;

        $matchList = [];
        foreach ($matchState->match as $matchKey => $matchItem) {
            $matchList[$matchKey] = $matchItem;
        }

        return $matchList;
    }

    /**
     * Select a list of active matches for a game.
     *
     * @param object $matchState
     * @param string $gameKey
     *
     * @return array
     */
    public static function selectMatchListForGame(
        $matchState,
        $gameKey
    ) {
        $matchState = (object) $matchState;
        $gameKey = (string) $gameKey;

        $matchList = [];
        foreach ($matchState->match as $matchKey => $matchItem) {
            if ($matchItem->gameKey != $gameKey) {
                continue;
            }

            $matchList[$matchKey] = $matchItem;
        }

        return $matchList;
    }

    /**
     * Get details about a single match from a match-state as returned by
     * the gameye api.
     *
     * @param object $matchState
     * @param string $matchKey
     *
     * @return object
     */
    public static function selectMatchItem(
        $matchState,
        $matchKey
    ) {
        $matchState = (object) $matchState;
        $matchKey = (string) $matchKey;

        $matchItem = $matchState->match->$matchKey;

        return $matchItem;
    }

    //endregion

    //region team

    /**
     * Get a list of all teams in the statistic-state.
     *
     * @param object $statisticState
     *
     * @return array
     */
    public static function selectTeamList(
        $statisticState
    ) {
        $statisticState = (object) $statisticState;

        $teamList = [];
        foreach ($statisticState->team as $teamKey => $teamItem) {
            $teamList[$teamKey] = $teamItem;
        }

        return $teamList;
    }

    /**
     * Get a single team from the statistic-state.
     *
     * @param object $statisticState
     * @param string $teamKey        name of the team
     *
     * @return object
     */
    public static function selectTeamItem(
        $statisticState,
        $teamKey
    ) {
        $statisticState = (object) $statisticState;
        $teamKey = (string) $teamKey;

        $teamItem = $statisticState->team->$teamKey;

        return $teamItem;
    }

    //endregion

    //region player

    /**
     * List all players in the match.
     *
     * @param object $statisticState
     *
     * @return array
     */
    public static function selectPlayerList(
        $statisticState
    ) {
        $statisticState = (object) $statisticState;

        $playerList = [];
        foreach ($statisticState->player as $playerKey => $playerItem) {
            $playerList[$playerKey] = $playerItem;
        }

        return $playerList;
    }

    /**
     * Get a list if all players in a team.
     *
     * @param object $statisticState
     * @param string $teamKey        name of the team
     *
     * @return array
     */
    public static function selectPlayerListForTeam(
        $statisticState,
        $teamKey
    ) {
        $statisticState = (object) $statisticState;

        $playerList = [];
        foreach ($statisticState->team->$teamKey->player as $playerKey => $playerEnabled) {
            $playerItem = $statisticState->player->$playerKey;
            $playerList[$playerKey] = $playerItem;
        }

        return $playerList;
    }

    /**
     * Get a single player in the match.
     *
     * @param object $statisticState
     *
     * @return object
     */
    public static function selectPlayerItem(
        $statisticState,
        $playerKey
    ) {
        $statisticState = (object) $statisticState;
        $playerKey = (string) $playerKey;

        $playerItem = $statisticState->player->$playerKey;

        return $playerItem;
    }

    //endregion
}
