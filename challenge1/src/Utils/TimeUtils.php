<?php

namespace App\Utils;

class TimeUtils
{
    public static function getTimeNowUTC(): \DateTimeImmutable
    {
        return (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC'));
    }

    public static function getTimeNowUTCint()
    {
        return (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC'))->getTimestamp();
    }
}
