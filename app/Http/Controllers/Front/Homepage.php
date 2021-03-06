<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mail;
use Validator;


//Models
use App\Models\News;
use App\Models\category;
use App\Models\Models\Page;
use App\Models\Models\Contact;
use App\Models\Config;

class Homepage extends Controller
{
    public function __construct(){
        if(Config::find(1)->active==0){
          return redirect()->to('site-bakımda')->send();
        }
        view()->share('pages',page::where('status',1)->orderBy('order','ASC')->get());
        view()->share('categories',Category::where('status',1)->inRandomOrder()->get());
    }

    public function index(){
      $data['news']=News::with('getCategory')->where('status',1)->whereHas('getCategory',function($query){
          $query->where('status',1);
        })->orderBy('created_at','DESC')->paginate(10);
      $data['news']->withPath(url('sayfa'));
      return view('front.homepage',$data);
    }

    public function single($category,$slug){
      $category=Category::whereSlug($category)->first()  ?? abort(403,'böyle bir kategori bulunamadı.');
      $article=news::whereSlug($slug)->whereCategoryId($category->id)->first()  ?? abort(403,'böyle bir yazı bulunamadı');
      $article->increment('hit');
      $data['article']=$article;
      return view('Front\single',$data);
    }

    public function category($slug){
      $category=Category::whereSlug($slug)->first() ?? abort(403,'böyle bir kategori bulunamadı.');
      $data['category']=$category;
      $data['news']=news::where('category_id',$category->id)->where('status',1)->orderBy('created_at','DESC')->paginate(1);
      return view('front.category',$data);
    }

    public function page($slug){
        $page=page::whereSlug($slug)->first()  ?? abort(403,'böyle bir sayfa bulunamadı.');
        $data['page']=$page;
        return view('front.page',$data);
    }

    public function contact(){
        return view('front.contact');
    }

    public function contactpost(Request $request){

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
            $message->to('ozkanyuksektepe@gmail.com');
            $message->setBody(' Mesajı Gönderen :'.$request->name.'<br />
                    Mesajı Gönderen Mail :'.$request->email.'<br />
                    Mesaj Konusu :'.$request->topic.'<br />
                    Mesaj :'.$request->message.'<br /><br />
                    Mesaj Gönderilme Tarihi : '.now().'','text/html');
            $message->subject($request->name. ' iletişiminden mesaj gönderdi!');
        });


        //$contact = new Contact;
        //$contact->name=$request->name;
        //$contact->email=$request->email;
        //$contact->topic=$request->email;
        //$contact->message=$request->message;
        //$contact->save();
        return redirect()->route('contact')->with('success','Mesajınız bize iletilmiştir. İlginiz için Çok Teşekkür ederiz.');
    }
}
