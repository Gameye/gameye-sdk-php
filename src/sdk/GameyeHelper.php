<?php

namespace Gameye\SDK;

/**
 * Gameye API helper.
 */
final class GameyeHelper
{
    private function __construct()
    {
    }

    /**
     * converts an milliseconds epoch (as used in the api states) to a
     * PHP DateTime object.
     *
     * @param int $epoch
     *
     * @return \DateTime
     */
    public static function toDateTime($epoch)
    {
        return \DateTime::createFromFormat('U', intval($epoch / 1000));
    }

    //region deprecated

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectMatchList(
        $matchState
    ) {
        return GameyeSelector::selectMatchList(
            $matchState
        );
    }

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectMatchListForGame(
        $matchState,
        $gameKey
    ) {
        return GameyeSelector::selectMatchListForGame(
            $matchState,
            $gameKey
        );
    }

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectMatchItem(
        $matchState,
        $matchKey
    ) {
        return GameyeSelector::selectMatchItem(
            $matchState,
            $matchKey
        );
    }

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectLocationListForGame(
        $gameState,
        $gameKey
    ) {
        return GameyeSelector::selectLocationListForGame(
            $gameState,
            $gameKey
        );
    }

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectTemplateList(
        $templateState
    ) {
        return GameyeSelector::selectTemplateList(
            $templateState
        );
    }

    /**
     * @deprecated Please use this function from the GameyeSelector class.
     */
    public static function selectTemplateItem(
        $templateState,
        $templateKey
    ) {
        return GameyeSelector::selectTemplateItem(
            $templateState,
            $templateKey
        );
    }

    //endregion
}
