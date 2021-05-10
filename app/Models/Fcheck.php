<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fcheck extends Model
{
    use HasFactory;

    public function books() {
        return $this->hasOne('App\Models\FcheckBook', 'fcheck_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\FcheckResolution', 'fcheck_id');
    }

    public function renew(){
        return $this->hasOne('App\Models\Fcheck', 'renewd_check_id');
    }
}
