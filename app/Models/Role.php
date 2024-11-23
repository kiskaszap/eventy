<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // The 'name' column is for storing role names (e.g., admin, vendor, user)
    ];

    /**
     * Define the relationship with the User model.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


}
