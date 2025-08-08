<?php

namespace App\Utils;

function getTimeNowUTC(): \DateTimeImmutable
{
    return (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('UTC'));
}
