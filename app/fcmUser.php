<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fcmUser extends Model
{
    protected $table = 'tblFcmUserApprovalDiskon';
    protected $fillable = ['name','fcm_token'];
}
