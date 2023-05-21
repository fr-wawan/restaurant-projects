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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsToMany(Transaction::class);
    }

    public function sumTransaction()
    {
        return $this->hasMany(Transaction::class)->selectRaw('transactions.food_id,SUM(transactions.amount) as total')->where('transactions.status', 'pending')->groupBy('transactions.food_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/foods/' . $value),
        );
    }
}
