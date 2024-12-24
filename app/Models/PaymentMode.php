<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    

    public function sale (){
        return $this->hasMany(Sale::class);
    }
}
