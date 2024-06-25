<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Restaurant;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'restaurant_id', 'date', 'time', 'number', 'visit_confirmation_at', 'paid_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getUser(){
        return $this->user->name;
    }

    public function getUserEmail(){
        return $this->user->email;
    }

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function getRestaurant(){
        return $this->restaurant->name;
    }

    public function isPast(){
        $datetime = \Carbon\Carbon::parse($this->date . ' ' . $this->time);
        return now() > $datetime;
    }
}
