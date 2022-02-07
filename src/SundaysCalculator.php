<?php

namespace MajaLin\PTest;

use Carbon\Carbon;
use DateTime;
use RuntimeException;

class SundaysCalculator
{
    public const WEEKDAYS = [
        'Mon' => 0,
        'Tue' => 1,
        'Wed' => 2,
        'Thu' => 3,
        'Fri' => 4,
        'Sat' => 5,
        'Sun' => 6,
    ];

    public function getSundays(string $dateFrom, string $dateTo): int
    {
        $dateFrom = DateTime::createFromFormat('d-m-Y', $dateFrom);
        $dateTo = DateTime::createFromFormat('d-m-Y', $dateTo);
        $sundaysCount = 0;

        if (!$dateFrom || !$dateTo) {
            throw new RuntimeException('Format for the input should be "dd-mm-yyyy"');
        }

        if ($dateFrom > $dateTo) {
            throw new RuntimeException('date_from should not be greater than date_to');
        }

        $baseWeekDay = $dateFrom->format('D');
        $endWeekDay = $dateTo->format('D');

        if ($baseWeekDay == 'Sun' || $endWeekDay === 'Sun') {
            $sundaysCount++;
        } elseif (self::WEEKDAYS[$baseWeekDay] > self::WEEKDAYS[$endWeekDay]) {
            $sundaysCount++;
        }

        $daysDiff = date_diff($dateFrom, $dateTo)->days;
        $weekDiff = (int) floor($daysDiff / 7);
        $sundaysCount += $weekDiff;

        return $sundaysCount;
    }
}
