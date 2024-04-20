<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllEventsBetweenDateXAndYTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function testActivities(): void
    {
        $activity = new Activity();
        $activity->date = '2022-01-10';
        $activity->activity = 'DX77';
        $activity->check_in_l = '0845';
        $activity->check_in_z = '0745';
        $activity->check_out_l = '1855';
        $activity->check_out_z = '1755';
        $activity->from = 'KRP';
        $activity->save();

        $activity = new Activity();
        $activity->date = '2022-01-23';
        $activity->activity = 'DX82';
        $activity->check_in_l = '1045';
        $activity->check_in_z = '0945';
        $activity->check_out_l = '2050';
        $activity->check_out_z = '1950';
        $activity->from = 'CPH';
        $activity->save();

        $response = $this->get('/api/activities?date_start=2022-01-10&date_end=2022-01-10');

        $response->assertStatus(200);
        $response->assertJsonCount(1);

        $response = $this->get('/api/activities?date_start=2022-01-10&date_end=2022-01-23');

        $response->assertStatus(200);
        $response->assertJsonCount(2);

        $response = $this->get('/api/activities?date_start=2022-01-10&date_end=2022-01-09');

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertTrue(session('errors')->has('date_end'));
        $this->assertEquals(
            'The date end field must be a date after or equal to date start.',
            session('errors')->first('date_end')
        );
    }
}
