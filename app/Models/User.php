<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;





class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'google_id',
        'email_verified_at', // Field for Google Authentication
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship with the Role model.
     * A user belongs to a specific role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship with the Comment model.
     * A user can have many comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relationship with the Event model through the bookings table.
     * A user can book many events.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookedEvents()
    {
        return $this->belongsToMany(Event::class, 'bookings', 'user_id', 'event_id')->withTimestamps();
    }
    
    /**
     * Mark the user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $saved = $this->save();

        if ($saved) {
            Log::info('Email verified successfully.', ['user_id' => $this->id]);
        } else {
            Log::error('Failed to verify email.', ['user_id' => $this->id]);
        }

        return $saved;
    }

    /**
     * Check if the user has verified their email.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Send an email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
{
    Log::info('Sending email verification notification.', ['user_id' => $this->id]);
    $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
}
}
