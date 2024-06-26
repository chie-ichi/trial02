<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Restaurant;

class Area extends Model
{
    use HasFactory;

    public function restaurant(){
        return $this->hasMany(Restaurant::class);
    }
}
