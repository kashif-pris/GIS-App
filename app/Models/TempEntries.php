<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempEntries extends Model
{
   
    protected $table = 'temp_locations';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];


}
