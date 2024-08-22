<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','image','is_active'];

//     هذه دالة تُعرّف علاقة بين الموديل Category والموديل الآخر الذي يمثل المنتجات (Products).
// العلاقة هنا تُشير إلى أن فئة واحدة (Category) يمكن أن تحتوي على العديد من المنتجات (Product). هذه العلاقة تُعرف باسم علاقة "واحد إلى العديد" (One-to-Many).
    public function products(){
        return $this->hasMany(Product::class);
    }

}
