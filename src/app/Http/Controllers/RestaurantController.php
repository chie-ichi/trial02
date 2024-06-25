<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Area;
use App\Models\Category;
use App\Models\Review;
use App\Http\Requests\RestaurantRequest;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('area')->get();
        $areas = Area::all();
        $categories = Category::all();
        return view('index', compact('restaurants', 'areas', 'categories'));
    }

    public function search(Request $request)
    {
        $restaurants = Restaurant::with('area', 'category')
            ->AreaSearch($request->area_id)
            ->CategorySearch($request->category_id)
            ->KeywordSearch($request->keyword)
            ->get();
        $areas = Area::all();
        $categories = Category::all();

        return view('index', compact('restaurants', 'areas', 'categories'));
    }

    public function detail($restaurant_id)
    {
        $restaurant = Restaurant::find($restaurant_id);
        $reviews = Review::where('restaurant_id', $restaurant_id)
            ->get();

        return view('detail', compact('restaurant', 'reviews'));
    }

    public function add(RestaurantRequest $request)
    {
        try {
            $image = $request->file('photo_file');
            $path = $image->store('public/img/upload');
            $public_path = str_replace('public/', '/storage/', $path);

            //店舗代表者情報を登録
            Restaurant::create([
                'owner_id' => $request['owner_id'],
                'name' => $request['name'],
                'area_id' => $request['area_id'],
                'category_id' => $request['category_id'],
                'photo' => $public_path,
                'description' => $request['description'],
            ]);
            return redirect('/owner')->with('flashSuccess', '飲食店情報の登録が完了しました');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect('/owner')->with('flashError', '飲食店情報登録時にエラーが発生しました: ' . $errorMessage);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = [];

            if(!empty($request->input('name'))) {
                $data['name'] = $request->input('name');
            }

            if(!empty($request->input('area_id'))) {
                $data['area_id'] = $request->input('area_id');
            }

            if(!empty($request->input('category_id'))) {
                $data['category_id'] = $request->input('category_id');
            }

            if(!empty($request->input('description'))) {
                $data['description'] = $request->input('description');
            }

            if($request->file('photo_file')) {
                $image = $request->file('photo_file');
                $path = $image->store('public/img/upload');
                $public_path = str_replace('public/', '/storage/', $path);
                $data['photo'] = $public_path;
            }

            Restaurant::find($request->id)->update($data);

            return redirect('/owner')->with('flashSuccess', '飲食店情報の更新が完了しました');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect('/owner')->with('flashError', '飲食店情報更新時にエラーが発生しました: ' . $errorMessage);
        }
    }
}
