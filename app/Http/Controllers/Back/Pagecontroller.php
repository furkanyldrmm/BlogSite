<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Sayfalar;
use App\Models\Yazilar;
use Illuminate\Http\Request;
use File;
class Pagecontroller extends Controller
{
    public function index()
    {
        $pages = Sayfalar::all();
        return view('back.pages.index', compact('pages'));
    }

    public function update($id)
    {
        $page = Sayfalar::findOrFail($id);
        return view('back.pages.update', compact('page'));
    }

    public function updatePost(Request $request, $id)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $page = Sayfalar::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->contentss;
        $page->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla güncellendi.');
        return redirect()->route('admin.page.index');
    }

    public function create()
    {
        return view('back.pages.create');
    }

    public function switch(Request $request)
    {
        $page = Sayfalar::findOrFail($request->id);
        $page->status = $request->statu == "true" ? 1 : 0;
        $page->save();
    }

    public function delete($id)
    {
        $page = Sayfalar::find($id);
        if (File::exists($page->image)) {
            File::delete(public_path($page->image));
        }
        $page->delete();
        toastr()->success('Sayfa başarıyla silindi');
        return redirect()->route('admin.page.index');
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $last = Sayfalar::orderBy('order', 'desc')->first();
        $page = new Sayfalar();
        $page->title = $request->title;
        $page->content = $request->deneme;
        $page->order = $last->order + 1;
        $page->slug = str_slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = str_slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla oluşturuldu');
        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request)
    {
        foreach ($request->get('page') as $key => $order) {
            Sayfalar::where('id', $order)->update(['order' => $key]);
        }
    }
}
