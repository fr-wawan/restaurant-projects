<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }


    public function costumer()
    {
        return $this->belongsTo(Costumer::class);
    }
}
