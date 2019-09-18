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

}
