<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fpayment extends Model
{
    use HasFactory;
    public function books() {
        return $this->hasMany('App\Models\FpaymentBook', 'fpayment_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\FpaymentResolution', 'fpayment_id');
    }
}
