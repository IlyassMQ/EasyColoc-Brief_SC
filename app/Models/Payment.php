<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable =['payer_id','receiver_id','colocation_id','amount','paid_at'];
}
