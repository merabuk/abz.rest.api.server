<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends BaseEntity
{
    use HasFactory;

    /**
     * Position has many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
