<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllFlightsThatStartOnTheGivenLocationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function testGivenLocationFlights(): void
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
        $activity->from = 'SVG';
        $activity->save();

        $response = $this->get('/api/activities/from/EBJ');

        $response->assertStatus(200);
        $response->assertJsonCount(0);

        $response = $this->get('/api/activities/from/SVG');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'from' => 'SVG',
        ]);
    }
}
