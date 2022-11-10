<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Models\BusinessSetting;
use Config;
use App\Models\TempEntries;
use Carbon\Carbon;
use DB;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   

        
        DB::table('temp_locations')->where('created_at' , '<' , date('Y-m-d'))->delete();

        $timezone = BusinessSetting::where(['key' => 'timezone'])->first();
        if ($timezone) {
            Config::set('timezone', $timezone->value);
            date_default_timezone_set($timezone->value);
        }
        Paginator::useBootstrap();
        try
        {
            Schema::defaultStringLength(191);            
        }
        catch (\Exception $ex) {
            info($ex);
        }
    }
}
