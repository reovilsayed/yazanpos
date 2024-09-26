<?php

namespace App\Facades\Settings;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;


class Settings
{
    public function price($value)
    {
        if($value){
            return number_format($value, 2) . ' ' . $this->currency();
        }
        return 0 . $this->currency();
    }

    public function currency()
    {
        return '$';
    }
    public function option($param = null){

        if($param){
            $settings = Cache::remember('settings',5, function () {
                return Setting::firstOrNew();
            });
            return $settings->{$param};
        }
        return null;
       
    }
}
