<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Area;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Owner;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['owner_id', 'name', 'area_id', 'category_id', 'photo', 'description'];

    public function getCategory(){
        return $this->category->name;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getArea(){
        return $this->area->name;
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }

    public function getReservations(){
        return $this->reservation;
    }

    public function isFavorite($user_id){
        return $this->favorite()->where('user_id', $user_id)->exists();
    }

    public function favorite(){
        return $this->hasMany(Favorite::class);
    }

    public function review(){
        return $this->hasMany(Review::class);
    }

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function getOwner(){
        return $this->owner;
    }

    public function scopeAreaSearch($query, $area_id) {
        if (!empty($area_id)) {
            $query->where('area_id', $area_id);
        }
    }

    public function scopeCategorySearch($query, $category_id) {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
        }
    }
}
