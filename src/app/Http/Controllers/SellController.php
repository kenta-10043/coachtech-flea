<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;


class SellController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('exhibitions.sell', compact('categories', 'conditions'));
    }
    // public function store(ExhibitionRequest $request)
    // {
    //     return view('exhibition.sell');
    // }
}
