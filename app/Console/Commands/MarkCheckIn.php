<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Config;
use Auth;
use DateTime;
use App\Models\TempEntries;
class MarkCheckIn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkin:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");
        // Main Attendance entry at attendance-time as per business settings
        // $attendanceTime=\App\Models\BusinessSetting::where('key','attendance_time')->first();

        // $new_time = Carbon::now()->format('h:i');
        // $now = $new_time;
        // $date1 = new DateTime($attendanceTime->value);
        // $date1->format('h:i');
        // if($now == $date1->format('h:i')){
        //     \Log::info('Successfully check in.');
        // }else{
        //     \Log::info('Waiting for attendance check in.');
        // }

        // $todayRecords = TempEntries::where('created_at', Carbon::today()->subDays(1)->format('Y-m-d'))->get();
      
    }
}
