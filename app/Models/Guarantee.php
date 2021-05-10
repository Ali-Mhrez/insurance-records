<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    public function books() {
        return $this->hasMany('App\Models\GuaranteeBook', 'guarantee_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\GuaranteeResolution', 'guarantee_id');
    }
}
