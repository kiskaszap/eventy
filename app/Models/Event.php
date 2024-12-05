<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'address',
        'location',
        'image',
        'created_by',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the comments for the event.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include events created by a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    public function bookedUsers()
    {
        return $this->belongsToMany(User::class, 'bookings', 'event_id', 'user_id')->withTimestamps();
    }
    

// Event Model


// User Model


}
