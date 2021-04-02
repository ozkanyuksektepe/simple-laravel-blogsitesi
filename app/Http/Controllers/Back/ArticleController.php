<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news=news::orderBy('created_at','desc')->get();
        return view('back.articles.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=category::all();
        return view('back.articles.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'min:3',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $news=new news;
        $news->title=$request->title;
        $news->category_id=$request->category;
        $news->content=$request->content;
        $news->slug=str::slug($request->title);

        if($request->hasFile('image')){
            $imageName=str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'),$imageName);
            $news->image='uploads/'.$imageName;
            }
           $news->save();
           toastr()->success('Başarılı', 'Makale Başarıyla Oluşturuldu');
           return redirect()->route('admin.makaleler.index');
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article=News::findOrFail($id);
        $categories=category::all();
        return view('back.articles.update',compact('categories','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        {
            $request->validate([
                'title'=>'min:3',
                'image'=>'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $news= News::findOrFail($id);
            $news->title=$request->title;
            $news->category_id=$request->category;
            $news->content=$request->content;
            $news->slug=str::slug($request->title);

            if($request->hasFile('image')){
                $imageName=str::slug($request->title).'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads'),$imageName);
                $news->image='uploads/'.$imageName;
            }
            $news->save();
            toastr()->success('Başarılı', 'Makale Başarıyla Güncellendi');
            return redirect()->route('admin.makaleler.index');
        }
    }

    public function switch(Request $request){
        $new=news::findOrFail($request->id);
        $new->status=$request->statu=="true" ? 1 : 0 ;
        $new->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id){
        News::find($id)->delete();
        toastr()->success('Silinen Makalelere Taşındı');
        return redirect()->route('admin.makaleler.index');
    }

    public function trashed(){
        $news= news::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('back.articles.trashed',compact('news'));
    }

    public function recover($id){
       News::onlyTrashed()->find($id)->restore();
        toastr()->success('Makale Başarıyla Geri Yüklendi');
        return redirect()->Back();
    }


    public function hardDelete($id){
        $new=News::onlyTrashed()->find($id);
        if(File::exists($new->image)){
            File::delete(public_path($new->image));
        }
        $new->forceDelete();
        toastr()->success('Makale Başarıyla Silindi');
        return redirect()->route('admin.makaleler.index');
    }
}
