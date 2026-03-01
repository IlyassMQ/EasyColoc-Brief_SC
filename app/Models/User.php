<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reputation',
        'banned_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function colocations()
    {
    return $this->belongsToMany(Colocation::class, 'colocation_user')
                ->withPivot('role_intern', 'joined_at');
    }

    public function expenses():HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function paymentsSent():HasMany
    {
        return $this->hasMany(Payment::class, 'payer_id');
    }

    public function paymentsReceived():HasMany
    {
        return $this->hasMany(Payment::class, 'receiver_id');
    }

    public function invitations():HasMany
    {
        return $this->hasMany(Invitation::class);
    }
}
