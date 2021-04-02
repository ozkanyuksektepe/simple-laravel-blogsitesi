<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Models\Page;

class Dashboard extends Controller
{
    public function index(){
        $news=News::all()->count();
        $hit=News::sum('hit');
        $category=Category::all()->count();
        $page=Page::all()->count();
        return view('back.dashboard',compact('news','hit','category','page'));
    }
}
