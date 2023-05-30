<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category_id', 'user_id', 'description', 'price', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsToMany(Transaction::class,'transaction_food');
    }



    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/foods/' . $value),
        );
    }
}
