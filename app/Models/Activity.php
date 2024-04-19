<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'rev',
        'dc',
        'check_in_l',
        'check_in_z',
        'check_out_l',
        'check_out_z',
        'activity',
        'remark',
        'from',
        'std_l',
        'std_z',
        'to',
        'sta_l',
        'sta_z',
        'ac_hotel',
        'blh',
        'flight_time',
        'night_time',
        'dur',
        'ext',
        'pax_booked',
        'acreg'
    ];
}
