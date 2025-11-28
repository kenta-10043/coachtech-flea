<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class SellController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('exhibitions.sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('item_image')->store('sample_images', 'public');
        $data = $request->validated();
        $data['item_image'] = $imagePath;
        $data['user_id'] = auth()->id();
        $data['condition_id'] = $data['condition'];
        unset($data['condition']);

        $item = Item::create($data);
        $item->categories()->attach($request->category);

        return redirect()->route('index')->with('success', '商品を出品しました');
    }
}
