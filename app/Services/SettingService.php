<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    static public function getValue(string $name) {
        return Setting::where('name', $name)->first()->current_value;
    }

    static public function getInterval(): int
    {
        return self::getValue('operation_interval') * 60;
    }
}
