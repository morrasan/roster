<?php

namespace App\Services;

use App\Enums\HtmlActivityFieldMapper;
use Carbon\Carbon;

class HtmlParserActivityService {
    public function parse (string $html): array {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $table = $dom->getElementById(config('roster.activity_table_id'));
        if ($table === null) return [];
        $rows = $table->getElementsByTagName('tr');
        $activities = [];
        $firstRowSkipped = false;
        foreach ($rows as $row) {
            $activityFields = [];
            $cells = $row->getElementsByTagName('td');
            if (!$firstRowSkipped) {
                $firstRowSkipped = true;
                continue;
            }
            foreach (HtmlActivityFieldMapper::toArray() as $fieldNumber) {
                $activityFields[$fieldNumber] = str_replace("\xc2\xa0", '', trim($cells->item($fieldNumber)->nodeValue));
            }
            $activities[] = $activityFields;
        }
        $this->normalizeDateAndCheckIn($activities);
        $normalizedActivities = $this->normalizeCheckOut($activities);

        return $this->mapNestedFields($normalizedActivities);
    }

    private function normalizeDateAndCheckIn (array &$activities): void {
        $prevDate = '';
        $prevCheckInL = '';
        $prevCheckInZ = '';
        foreach ($activities as &$activityFields) {
            if (empty($activityFields[HtmlActivityFieldMapper::DATE])) {
                $activityFields[HtmlActivityFieldMapper::DATE] = $prevDate;
            } else {
                $prevDate = $activityFields[HtmlActivityFieldMapper::DATE];
            }
            if (empty($activityFields[HtmlActivityFieldMapper::CHECK_IN_L])
                && empty($activityFields[HtmlActivityFieldMapper::CHECK_IN_Z])
                && $activityFields[HtmlActivityFieldMapper::ACTIVITY] != 'OFF')
            {
                $activityFields[HtmlActivityFieldMapper::CHECK_IN_L] = $prevCheckInL;
                $activityFields[HtmlActivityFieldMapper::CHECK_IN_Z] = $prevCheckInZ;
            } else {
                $prevCheckInL = $activityFields[HtmlActivityFieldMapper::CHECK_IN_L];
                $prevCheckInZ = $activityFields[HtmlActivityFieldMapper::CHECK_IN_Z];
            }
        }
    }

    private function normalizeCheckOut (array $activities): array {
        $reversedActivities = array_reverse($activities);
        $prevCheckOutL = '';
        $prevCheckOutZ = '';
        foreach ($reversedActivities as &$activityFields) {
            if (empty($activityFields[HtmlActivityFieldMapper::CHECK_OUT_L])
                && empty($activityFields[HtmlActivityFieldMapper::CHECK_OUT_Z])
                && $activityFields[HtmlActivityFieldMapper::ACTIVITY] != 'OFF')
            {
                $activityFields[HtmlActivityFieldMapper::CHECK_OUT_L] = $prevCheckOutL;
                $activityFields[HtmlActivityFieldMapper::CHECK_OUT_Z] = $prevCheckOutZ;
            } else {
                $prevCheckOutL = $activityFields[HtmlActivityFieldMapper::CHECK_OUT_L];
                $prevCheckOutZ = $activityFields[HtmlActivityFieldMapper::CHECK_OUT_Z];
            }
        }
        return array_reverse($reversedActivities);
    }

    private function mapNestedFields (array $activities): array {
        $mappedActivities = [];
        $postfixDate = Carbon::parse(config('roster.date_init'))->format(' M Y');
        foreach ($activities as $activityFields) {
            $mappedActivities[] = [
                'date'          => Carbon::parse($activityFields[HtmlActivityFieldMapper::DATE] . $postfixDate)->format('Y-m-d'),
                'rev'           => $activityFields[HtmlActivityFieldMapper::REV],
                'dc'            => $activityFields[HtmlActivityFieldMapper::DC],
                'check_in_l'    => $activityFields[HtmlActivityFieldMapper::CHECK_IN_L],
                'check_in_z'    => $activityFields[HtmlActivityFieldMapper::CHECK_IN_Z],
                'check_out_l'   => $activityFields[HtmlActivityFieldMapper::CHECK_OUT_L],
                'check_out_z'   => $activityFields[HtmlActivityFieldMapper::CHECK_OUT_Z],
                'activity'      => $activityFields[HtmlActivityFieldMapper::ACTIVITY],
                'remark'        => $activityFields[HtmlActivityFieldMapper::REMARK],
                'from'          => $activityFields[HtmlActivityFieldMapper::FROM],
                'std_l'         => $activityFields[HtmlActivityFieldMapper::STD_L],
                'std_z'         => $activityFields[HtmlActivityFieldMapper::STD_Z],
                'to'            => $activityFields[HtmlActivityFieldMapper::TO],
                'sta_l'         => $activityFields[HtmlActivityFieldMapper::STA_L],
                'sta_z'         => $activityFields[HtmlActivityFieldMapper::STA_Z],
                'ac_hotel'      => $activityFields[HtmlActivityFieldMapper::AC_HOTEL],
                'blh'           => $activityFields[HtmlActivityFieldMapper::BLH],
                'flight_time'   => $activityFields[HtmlActivityFieldMapper::FLIGHT_TIME],
                'night_time'    => $activityFields[HtmlActivityFieldMapper::NIGHT_TIME],
                'dur'           => $activityFields[HtmlActivityFieldMapper::DUR],
                'ext'           => $activityFields[HtmlActivityFieldMapper::EXT],
                'pax_booked'    => $activityFields[HtmlActivityFieldMapper::PAX_BOOKED],
                'acreg'         => $activityFields[HtmlActivityFieldMapper::ACREG],
            ];
        }
        return $mappedActivities;
    }
}
