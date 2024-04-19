<?php

namespace App\Repositories;

use App\Models\Activity;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ActivityRepository {

    /**
     * @param array $activities
     *
     * @return void
     */
    public function createMany (array $activities): void {
        foreach ($activities as $activityFields) {
            DB::table(app(Activity::class)->getTable())->insert($activityFields);
        }
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     *
     * @return Collection
     */
    public function getActivities (string $dateStart, string $dateEnd): Collection {
        return DB::table(app(Activity::class)->getTable())
            ->where('date', '>=', $dateStart)
            ->where('date', '<=', $dateEnd)
            ->get();
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     *
     * @return Collection
     */
    public function getFlights (string $dateStart, string $dateEnd): Collection {
        return DB::table(app(Activity::class)->getTable())
            ->where('date', '>=', $dateStart)
            ->where('date', '<=', $dateEnd)
            ->whereRaw('activity GLOB "[A-Z][A-Z][0-9]*"')
            ->get();
    }

    /**
     * @param string $dateStart
     * @param string $dateEnd
     *
     * @return Collection
     */
    public function getStandby (string $dateStart, string $dateEnd): Collection {
        return DB::table(app(Activity::class)->getTable())
            ->where('date', '>=', $dateStart)
            ->where('date', '<=', $dateEnd)
            ->where('activity', '=', 'OFF')
            ->get();
    }

    /**
     * @param string $location
     *
     * @return Collection
     */
    public function getFlightsFromLocation (string $location): Collection {
        return DB::table(app(Activity::class)->getTable())
            ->where('from', '=', $location)
            ->get();
    }
}
