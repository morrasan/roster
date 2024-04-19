<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActivitiesRequest;
use App\Http\Requests\Api\UploadFileRequest;
use App\Repositories\ActivityRepository;
use App\Services\DateRangeService;
use App\Services\HtmlParserActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ActivityController extends Controller
{
    /**
     * @param ActivitiesRequest $request
     *
     * @return Collection
     */
    public function index (ActivitiesRequest $request): Collection {
        $repository = new ActivityRepository();
        return $repository->getActivities($request->date_start, $request->date_end);
    }

    /**
     * @param UploadFileRequest $request
     *
     * @return JsonResponse
     */
    public function store (UploadFileRequest $request): JsonResponse {
        $htmlFile = $request->file('roster');
        $htmlContent = file_get_contents($htmlFile);
        $parser = new HtmlParserActivityService();
        $activities = $parser->parse($htmlContent);
        $repository = new ActivityRepository();
        $repository->createMany($activities);
        return response()->json(['status' => 'success']);
    }

    /**
     * @return Collection
     */
    public function nextWeekActivities (): Collection {
        $repository = new ActivityRepository();
        $dateRangeService = new DateRangeService();
        [$dateStart, $dateEnd] = $dateRangeService->getNextWeekDateRangeByDate();
        return $repository->getFlights($dateStart, $dateEnd);
    }

    /**
     * @return Collection
     */
    public function standbyNextWeekActivities (): Collection {
        $repository = new ActivityRepository();
        $dateRangeService = new DateRangeService();
        [$dateStart, $dateEnd] = $dateRangeService->getNextWeekDateRangeByDate();
        return $repository->getStandby($dateStart, $dateEnd);
    }

    /**
     * @param string $location
     *
     * @return Collection
     */
    public function activitiesFromLocation (string $location): Collection {
        $repository = new ActivityRepository();
        return $repository->getFlightsFromLocation($location);
    }
}
