<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[

         'category_id','brand_id',
         'name','slug','images',
         'descriptian','price',
         'is_active','is_featured',
         'in_stock',
         'on_sale'         
];

//   مفيدة جدًا في تحويل القيم من قاعدة البيانات إلى النوع المناسب تلقائيًا عند جلب البيانات   $castsخاصية 
   protected $casts = ['images' => 'array'];// explan in the Notes

   public function category(){
    return $this->belongsTo(Category::class); // العلاقة belongsTo تُشير إلى أن هذا الموديل (مثل Product) ينتمي إلى كائن واحد من موديل آخر (مثل Category).
   }

   public function brand(){
    return $this->belongsTo(Brand::class); // العلاقة belongsTo تُشير إلى أن هذا الموديل (مثل Product) ينتمي إلى كائن واحد من موديل آخر (مثل Category).
   }

   public function orderItem(){
    return $this->belongsTo(OrderItem::class); // العلاقة belongsTo تُشير إلى أن هذا الموديل (مثل Product) ينتمي إلى كائن واحد من موديل آخر (مثل Category).
   }

}
