<?php

namespace App\Services;

use Carbon\Carbon;

class DateRangeService {

    protected Carbon $dateInit;

    public function __construct () {
        $this->dateInit = Carbon::parse(config('roster.date_init'));
    }

    /**
     * @return array
     */
    public function getNextWeekDateRangeByDate (): array {
        $startDate = $this->dateInit->startOfWeek()->addWeek()->format('Y-m-d');
        $endDate = $this->dateInit->endOfWeek()->format('Y-m-d');
        return [$startDate, $endDate];
    }
}
