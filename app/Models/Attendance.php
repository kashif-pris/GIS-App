<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Attendance extends Authenticatable
{
    use Notifiable;
    protected $table = 'attendance';
    protected $guarded = [];

   public function employee(){
    // return $this->belongsTo(Restaurant::class);
       return $this->belongsTo(Admin::class,'employee_id');
   }
}
