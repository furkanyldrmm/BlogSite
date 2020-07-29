<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Sayfalar;
use App\Models\Yazilar;
use App\Models\Category;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index(){
        $article=Yazilar::all()->count();
        $hit=Yazilar::sum('hit');
        $category=Category::all()->count();
        $page=Sayfalar::all()->count();
        return view('back.dashboard',compact('article','hit','category','page'));
    }
}
