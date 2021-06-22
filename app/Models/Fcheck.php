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
    // public function parent()
    // {
    //     return $this->belongsTo('App\Models\Fcheck','renewd_check_id')->where('renewd_check_id',NULL);
    // }

    // public function children()
    // {
    //     return $this->hasOne('App\Models\Fcheck','renewd_check_id');
    // }
}
