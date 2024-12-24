<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductCategory extends Model
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

        static::created(function ($category) {
            Activity::create([
                'subject'  => 'Product category created',
                'content' => sprintf(
                    '%s [%s] created a new product category: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $category->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::updated(function ($category) {
            Activity::create([
                'subject'  => 'Product category updated',
                'content' => sprintf(
                    '%s [%s] updated product category to %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $category->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::deleted(function ($category) {
            Activity::create([
                'subject'  => 'Product category deleted',
                'content' => sprintf(
                    '%s [%s] deleted product category: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $category->title,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
