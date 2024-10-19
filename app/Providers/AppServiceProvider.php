<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Validator::extend('valArrayNotEmpty', function ($attribute, $value, $parameters, $validator) {
            $arrs = json_decode($value, true);
           
            foreach ($arrs as $arr) {
                foreach ($arr as $key => $val) {
                    if (trim($val) == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        });
        \Validator::extend('keyArrayNotEmpty', function ($attribute, $value, $parameters, $validator) {
            $arrs = json_decode($value, true);
            foreach ($arrs as $arr) {
                foreach ($arr as $key => $val) {
                    if (trim($key) == "") {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        });
        \Validator::extend('title_exists', function ($attribute, $value, $parameters, $validator) {
            if(isset($parameters[1])) {
                if(checkTitle($value, $parameters[0], $parameters[1]) > 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if (checkTitle($value, $parameters[0]) > 0) {
                    return false;
                } else {
                    return true;
                }
            }
        });
        \Validator::extend('tahun_terbit_min', function ($attribute, $value, $parameters, $validator) {
            if(strtotime(intval($value)) >= strtotime(date('Y'))){
                return true;
            } else {
                return false;
            }
        });
        \Validator::extend('bulan_terbit_min', function ($attribute, $value, $parameters, $validator) {
            if(strtotime(date('Y-m')) <= strtotime(str($parameters[0]) .'-'. str($value))){
                return true;
            } else {
                return false;
            }
        });
    }
}
