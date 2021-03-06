<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Services\DateTimeFormatter;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at',
    ];

    protected $appends = [
        'image_path',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return DateTimeFormatter::format($value, DateTimeFormatter::SHORT_DATE_TIME);
    }

    public function getUpdatedAtAttribute($value)
    {
        return DateTimeFormatter::format($value, DateTimeFormatter::SHORT_DATE_TIME);
    }

    public static function search($term)
    {
        if ($term) {
            $searchTerm = "%{$term}%";
            return User::query()->where('name', 'LIKE', $searchTerm)->orWhere('email', 'LIKE', $searchTerm)->get();
        }

        return User::all();
    }

    public function getImagePathAttribute()
    {
        if ($this->getOriginal('image') == null) {
            return '/assets/images/default/users/default-user.png';
        }

        return '/uploads/users/' . $this->id . '/' . $this->getOriginal('image');
    }

    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
}
