<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Colocation extends Model
{
    protected $fillable = ['name','description','status'];


    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withPivot('role_intern','joined_at','left_at')->withTimestamps();
    }

    public function categories(): HasMany{
        return $this->hasMany(Category::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function payments():HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function invitations():HasMany
    {
        return $this->hasMany(Invitation::class);
    }
}
