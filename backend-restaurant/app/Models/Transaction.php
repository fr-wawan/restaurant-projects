<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice', 'name', 'food_id', 'costumer_id', 'amount', 'description', 'status', 'snap_token', 'phone', 'pin_code', 'address', 'description'
    ];

    public function food()
    {
        return $this->belongsToMany(Food::class, 'transaction_food')->withPivot('quantity');
    }

    public function costumer()
    {
        return $this->belongsTo(Costumer::class);
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-m-Y')
        );
    }
}
