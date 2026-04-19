<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'state',
        'Zip_code',
    ];

    // العلاقة: عنوان ينتمي إلى طلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Accessor لاسترجاع الاسم الكامل
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

