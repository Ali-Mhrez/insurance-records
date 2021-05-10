<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashPaymentAndRemittanceInsurance extends Model
{
    use HasFactory;

    public function book() {
        return $this->hasOne('App\Models\PaymentAndRemittanceBook', 'payment_id');
    }

    public function resolution() {
        return $this->hasOne('App\Models\PaymentAndRemittanceResolution', 'payment_id');
    }
}
