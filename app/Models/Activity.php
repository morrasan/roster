<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * @package App\Models
 *
 * @property integer id
 * @property string date
 * @property string rev
 * @property string dc
 * @property string check_in_l
 * @property string check_in_z
 * @property string check_out_l
 * @property string check_out_z
 * @property string activity
 * @property string remark
 * @property string from
 * @property string std_l
 * @property string std_z
 * @property string to
 * @property string sta_l
 * @property string sta_z
 * @property string ac_hotel
 * @property string blh
 * @property string flight_time
 * @property string night_time
 * @property string dur
 * @property string ext
 * @property string pax_booked
 * @property string acreg
 */
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
