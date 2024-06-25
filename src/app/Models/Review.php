<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Restaurant;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'restaurant_id', 'stars', 'comment'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getUser(){
        return $this->user->name;
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function getRestaurant(){
        return $this->restaurant->name;
    }
}
