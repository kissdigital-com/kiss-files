<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entity{
/**
 * App\Entity\File
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_key
 * @property string $original_name
 * @property string $path
 * @property int $size
 * @property int $downloads
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entity\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereAccessKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereDownloads($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereOriginalName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\File whereUserId($value)
 */
	class File extends \Eloquent {}
}

namespace App\Entity{
/**
 * App\Entity\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $provider
 * @property string $provider_id
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\File[] $files
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
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
	class User extends \Eloquent {}
}

