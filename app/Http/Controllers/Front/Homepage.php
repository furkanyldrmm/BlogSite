<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Yazilar;
use App\Models\Sayfalar;
use App\Models\Yorumlar;
use App\Models\Config;
use Mail;
use Validator;

class Homepage extends Controller
{
    public function __construct()
    {

        if (Config::find(1)->active == 0) {
            return redirect()->to('site-bakimda')->send();
        }

        view()->share('sayfalar', Sayfalar::where('status',1)->orderBy('order', 'ASC')->get());
        view()->share('categories', Category::where('status',1)->get());
        view()->share('config',Config::find(1));

    }

    public function index()
    {

        $data['yazilar'] = Yazilar::with('getCategory')->where('status',1)->whereHas('getCategory',function ($query){
            $query->where('status',1);
        })->orderBy('created_at', 'DESC')->paginate(10);

        $data['yazilar']->withPath(url('/sayfa'));
        return view('homepage', $data);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Böyle bir kategori bulunamadı');

        $hit = Yazilar::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403, 'Bir şeyler ters gitti');
        $hit->increment('hit');
        $data['deneme'] = $hit;

        return view('single', $data);
    }

    public function category($slug)
    {

        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle bir kategori bulunamadı');

        $data['category'] = $category;
        $data['yazilar'] = Yazilar::where('category_id', $category->id)->where('status',1)->orderBy('created_at', 'DESC')->paginate(1);
        return view('category', $data);
    }

    public function page($slug)
    {

        $page = Sayfalar::whereSlug($slug)->first() ?? abort(403, 'Boyle bir sayfa bulunamadı');
        $data['sayfa'] = $page;

        return view('page', $data);
    }

    public function contact()
    {
        return view('content');
    }

    public function contactpost(Request $request){
        /*contact=new Yorumlar();
    $contact->name=$request->name;
    $contact->email=$request->email;
    $contact->topic=$request->topic;
    $contact->message=$request->message;
    $contact->save();*/

        $rules=[
            'name'=>'required|min:5',
            'email'=>'required|email',
            'topic'=>'required',
            'message'=>'required|min:10'
        ];
        $validate=Validator::make($request->post(),$rules);

        if($validate->fails()){
            return redirect()->route('contact')->withErrors($validate)->withInput();
        }

        Mail::send([],[], function($message) use($request){
            $message->from('iletisim@blogsitesi.com','Blog Sitesi');
            $message->to('furkangurel@hotmail.com');
            $message->setBody(' Mesajı Gönderen :'.$request->name.'<br />
                    Mesajı Gönderen Mail :'.$request->email.'<br />
                    Mesaj Konusu : '.$request->topic.'<br />
                    Mesaj :'.$request->message.'<br /><br />
                    Mesaj Gönderilme Tarihi : '.now().'','text/html');
            $message->subject($request->name. ' iletişimden mesaj gönderdi!');
        });
return redirect()->route('contact')->with('success','Mesajınız bize iletildi. Teşekkür ederiz !');
    }
}
