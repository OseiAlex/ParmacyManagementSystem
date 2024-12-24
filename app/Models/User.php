<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        'username',
        'email',
        'phone',
        'is_admin',
        'password',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });


        static::created(function ($user) {
            Activity::create([
                'subject'  => 'User created',
                'content' => sprintf(
                    '%s [%s] created a new user account for %s [%s] at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $user->name,
                    $user->username,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::updated(function ($user) {
            if ($user->isDirty('password')) {
                $action = Auth::id() == $user->id ? 'changed their password' : 'reset the password for ' . $user->name . ' [' . $user->username . ']';
                $content = sprintf(
                    '%s [%s] %s at %s',
                    Auth::user()->name,
                    Auth::user()->username,
                    $action,
                    Carbon::now()->toDayDateTimeString()
                );

                Activity::create([
                    'subject' => 'Password updated',
                    'content' => $content,
                ]);
            } else {
                $action = Auth::id() == $user->id ? 'their profile information' : 'the profile information for ' . $user->name . ' [' . $user->username . ']';
                $content = sprintf(
                    '%s [%s] updated %s at %s',
                    Auth::user()->name,
                    Auth::user()->username,
                    $action,
                    Carbon::now()->toDayDateTimeString()
                );
                Activity::create([
                    'subject'  => 'User updated',
                    'content' => $content
                ]);
            }
        });

        static::deleted(function ($user) {
            Activity::create([
                'subject'  => 'User deleted',
                'content' => sprintf(
                    '%s [%s] deleted the user account for %s [%s] at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $user->name,
                    $user->username,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });
    }

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

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
