<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Sale extends Model
{
    protected $fillable = [
        'name',
        'payment_mode_id',
        'amount_due',
        'amount_paid',
        'amount_debt',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });

        static::created(function ($item) {
            Activity::create([
                'subject'  => 'Sales created',
                'content' => sprintf(
                    '%s [%s] created a new sales for %s GHC worth %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->name,
                    number_format($item->amount_due ,2),
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::updated(function ($item) {
            Activity::create([
                'subject'  => 'Sales updated',
                'content' => sprintf(
                    '%s [%s] updated sales for %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->name,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::deleted(function ($item) {
            Activity::create([
                'subject'  => 'Sales deleted',
                'content' => sprintf(
                    '%s [%s] deleted sales for %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->name,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function product() {
        return $this->belongsToMany(Product::class)
                    ->withPivot('qty')
                    ->withTimestamps();
    }
}
