<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\User;

class File extends Model
{
    /**
     * Get the owner of this file
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
