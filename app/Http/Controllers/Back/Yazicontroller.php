<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Console\Scheduling\CacheAware;
use Illuminate\Http\Request;
use App\Models\Yazilar;
use App\Models\Category;

use Illuminate\Support\Facades\File;
class Yazicontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $yazilar = Yazilar::orderBy('created_at', 'ASC')->get();

        return view('back.yazilar.index', compact('yazilar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('back.yazilar.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'

        ]);
        $article = new Yazilar;
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->deneme;
        $article->slug = str_slug($request->title);

        if ($request->hasFile('image')) {

            $imagename = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imagename);
            $article->image = 'uploads/' . $imagename;
        }
        $article->save();
        toastr()->success('Basarili', 'Post başarıyla oluşturuldu');
        return redirect()->route('admin.yazilar.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Yazilar::findOrFail($id);
        $categories = Category::all();
        return view('back.yazilar.update', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => '|image|mimes:jpeg,png,jpg|max:2048'

        ]);
        $article = Yazilar::findOrFail($id);
        $article->title = $request->title;
        $article->category_id = $request->category;
        $article->content = $request->deneme;
        $article->slug = str_slug($request->title);

        if ($request->hasFile('image')) {

            $imagename = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imagename);
            $article->image = 'uploads/' . $imagename;
        }
        $article->save();
        toastr()->success('Basarili', 'Post başarıyla güncellendi');
        return redirect()->route('admin.yazilar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sil($id) {
        Yazilar::find($id)->delete();
        toastr()->success('Geri dönüşüme yollandı');
        return redirect()->route('admin.yazilar.index');


    }
    public function destroy($id)
    {
        //
    }

    public function switch(Request $request)
    {
        $article = Yazilar::findOrFail($request->id);
        $article->status = $request->statu == "true" ? 1 : 0;
        $article->save();

    }
    public function trashed(){
$yazilar=Yazilar::onlyTrashed()->orderBy('created_at','desc')->get();
return view('back.yazilar.trashed',compact('yazilar'));
    }
    public function  recover($id){
Yazilar::onlyTrashed()->find($id)->restore();
        toastr()->success('Post kurtarıldı');
        return redirect()->back();
    }

    public function harddelete($id){
$yazi=Yazilar::onlyTrashed()->find($id);

        if(File::exists($yazi->image)){
            File::delete(public_path($yazi->image));
        }
        $yazi->forceDelete();
        toastr()->success('Yazi başarıyla silindi');
        return redirect()->route('admin.yazilar.index');



    }
}
