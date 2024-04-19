<?php

namespace App\Enums;

class HtmlActivityFieldMapper {
    const DATE = 1;
    const REV = 2;
    const DC = 3;
    const CHECK_IN_L = 4;
    const CHECK_IN_Z = 5;
    const CHECK_OUT_L = 6;
    const CHECK_OUT_Z = 7;
    const ACTIVITY = 8;
    const REMARK = 9;
    const FROM = 11;
    const STD_L = 12;
    const STD_Z = 13;
    const TO = 15;
    const STA_L = 16;
    const STA_Z = 17;
    const AC_HOTEL = 19;
    const BLH = 20;
    const FLIGHT_TIME = 21;
    const NIGHT_TIME = 22;
    const DUR = 23;
    const EXT = 24;
    const PAX_BOOKED = 26;
    const ACREG = 27;

    public static function toArray (): array {
        return [
            self::DATE,
            self::REV,
            self::DC,
            self::CHECK_IN_L,
            self::CHECK_IN_Z,
            self::CHECK_OUT_L,
            self::CHECK_OUT_Z,
            self::ACTIVITY,
            self::REMARK,
            self::FROM,
            self::STD_L,
            self::STD_Z,
            self::TO,
            self::STA_L,
            self::STA_Z,
            self::AC_HOTEL,
            self::BLH,
            self::FLIGHT_TIME,
            self::NIGHT_TIME,
            self::DUR,
            self::EXT,
            self::PAX_BOOKED,
            self::ACREG
        ];
    }
}
