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

    /**
     * Select a list of active matches.
     *
     * @param object $matchState
     *
     * @return object
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

    /**
     * Selects all locations for a given game.
     *
     * @param object $gameState
     * @param string $gameKey
     *
     * @return array
     */
    public static function selectLocationListForGame(
        $gameState,
        $gameKey
    ) {
        $gameState = (object) $gameState;
        $gameKey = (string) $gameKey;

        $locationList = [];
        foreach ($gameState->game->$gameKey->location as $locationKey => $hasLocation) {
            if (!$hasLocation) {
                continue;
            }

            $locationItem = $gameState->location->$locationKey;
            $locationList[$locationKey] = $locationItem;
        }

        return $locationList;
    }

    /**
     * Select a list of templates.
     *
     * @param object $templateState
     *
     * @return object
     */
    public static function selectTemplateList(
        $templateState
    ) {
        $templateState = (object) $templateState;

        $templateList = [];
        foreach ($templateState->template as $templateKey => $templateItem) {
            $templateList[$templateKey] = $templateItem;
        }

        return $templateList;
    }

    /**
     * Get details about a single template from a template-state as returned by
     * the gameye api.
     *
     * @param object $templateState
     * @param string $templateKey
     *
     * @return object
     */
    public static function selectTemplateItem(
        $templateState,
        $templateKey
    ) {
        $templateState = (object) $templateState;
        $templateKey = (string) $templateKey;

        $templateItem = $templateState->template->$templateKey;

        return $templateItem;
    }
}
