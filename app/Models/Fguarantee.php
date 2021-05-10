<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fguarantee extends Model
{
    use HasFactory;
    public function books() {
        return $this->hasMany('App\Models\FguaranteeBook', 'fguarantee_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\FguaranteeResolution', 'fguarantee_id');
    }
}
