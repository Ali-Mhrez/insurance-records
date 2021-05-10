<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;

    public function books() {
        return $this->hasOne('App\Models\CheckBook', 'check_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\CheckResolution', 'check_id');
    }
}
