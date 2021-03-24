<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = 'Xts_vehicleorderformExtensionBase';
    protected $fillable = ['xts_status','xts_approvename', 'xts_approvaldiscount', 'xts_appdistime'];
}
