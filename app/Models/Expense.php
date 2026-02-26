<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['colocation_id', 'category_id', 'user_id', 'title', 'amount', 'date'];
}
