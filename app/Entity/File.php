<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\User;

/**
 * App\Entity\File
 *
 * @property-read \App\Entity\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $access_key
 * @property string $original_file_name
 * @property string $file_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereAccessKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereOriginalFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereUserId($value)
 */
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
