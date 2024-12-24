<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'name',
      'generic_name',
      'manufacturer',
      'product_category_id',
      'measuring_unit_id',
      'cost_price',
      'discount',
      'markup_percentage',
      'selling_price',
      'stock_level_at_dispensary',
      'stock_level_at_store',
      'restock_level_at_dispensary',
      'restock_level_at_store',
      'is_delisted',
      'expires_at'        
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });

        static::created(function ($product) {
            Activity::create([
                'subject'  => 'Product added',
                'content' => sprintf(
                    '%s [%s] created a new product: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $product->name,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::updated(function ($product) {
            Activity::create([
                'subject'  => 'Product updated',
                'content' => sprintf(
                    '%s [%s] updated a product: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $product->name,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });

        static::deleted(function ($product) {
            Activity::create([
                'subject'  => 'Product deleted',
                'content' => sprintf(
                    '%s [%s] deleted product: %s at %s.',
                    Auth::user()->name,
                    Auth::user()->username,
                    $product->name,
                    Carbon::now()->toDayDateTimeString()
                ),
            ]);
        });
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function measuring_unit(){
        return $this->belongsTo(MeasuringUnit::class);
    }

    public function location(){
        return $this->belongsToMany(Location::class);
    }

    public function sale(){
        return $this->belongsToMany(Sale::class)
                ->withPivot('qty')
                ->withTimestamps();
    }
}
