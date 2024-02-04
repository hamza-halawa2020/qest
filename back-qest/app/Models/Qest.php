<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'product_name',
        'user_image',
        'normal_price',
        'price_with_extra',
        // '1_month',
        // '2_month',
        // '3_month',
        // '4_month',
        // '5_month',
        // '6_month',
        // '7_month',
        // '8_month',
        // '9_month',
        // '10_month',
        // '11_month',
        // '12_month',
        'notes',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
