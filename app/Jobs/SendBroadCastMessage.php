<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Models\TempEntries;
class SendBroadCastMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $status)
    {
        $this->details = $details;
        $this->status = $status;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        throw new \Exception('Something went wrong');
        // DB::table('temp_locations')->insert([
        //     'lat'=>$this->details->lat,
        //     'long'=>$this->details->long,
        //     'user'=>$this->details->user_id,
        //     'player_id'=>$this->details->player_id,
        //     'status'=>$status,
        //     'app_state'=>$this->details->app_state,
        //     'time'=>date('h:i'),
        //     'timestamp'=>$this->details->timestamp

        // ]);
    }
}
