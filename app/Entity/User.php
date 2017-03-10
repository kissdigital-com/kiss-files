<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Entity\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\File[] $files
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $provider
 * @property string $provider_id
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereProviderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get user's files
     */
    public function files()
    {
        return $this->hasMany('App\Entity\File');
    }
}
