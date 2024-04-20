<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllStandbyForTheNextWeekTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function testStandByNextWeek(): void
    {
        $activity = new Activity();
        $activity->date = '2022-01-10';
        $activity->activity = 'OFF';
        $activity->from = 'KRP';
        $activity->save();

        $activity = new Activity();
        $activity->date = '2022-01-23';
        $activity->activity = 'OFF';
        $activity->from = 'CPH';
        $activity->save();

        $response = $this->get('/api/activities/standby-next-week');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'activity' => 'OFF',
        ]);
    }
}
