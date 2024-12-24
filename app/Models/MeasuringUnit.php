<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MeasuringUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title'
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
                'subject'  => 'Measuring unit created',
                'content' => sprintf(
                    '%s [%s] created a new measuring unit: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::updated(function ($item) {
            Activity::create([
                'subject'  => 'Measuring unit updated',
                'content' => sprintf(
                    '%s [%s] updated measuring unit to %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::deleted(function ($item) {
            Activity::create([
                'subject'  => 'Measuring unit deleted',
                'content' => sprintf(
                    '%s [%s] deleted measuring unit: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $item->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });
    }

    public function product(){
        return $this->hasMany(Product::class);
    }
}
