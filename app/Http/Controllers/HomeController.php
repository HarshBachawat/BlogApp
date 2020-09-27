<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Category;
use Auth;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['singleBlog','welcome']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function welcome() {
        $blogs = Blog::orderBy('created_at','DESC')->paginate(3);
        return view('welcome',compact('blogs'));
    }

    public function index() {
        return view('home');
    }

    public function singleBlog($blog_id) {
        $blog = Blog::findOrFail($blog_id);
        return view('single-blog',compact('blog'));
    }

    public function createBlog() {
        return view('create-blog');
    }

    public function addBlog(Request $request) {
        $filePath = '';
        if($request->hasFile('cover_img'))
        {
          // Get filename with the extension
          $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
          // Get just filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          // Get just ext
          $extension = $request->file('cover_img')->getClientOriginalExtension();
          // Filename to store
          $fileNameToStore= $filename.'_'.time().'.'.$extension;
          $filePath = 'cover_img/' . $fileNameToStore;
          // Upload Image
          $file = $request->file('cover_img');
          Storage::disk('public')->put($filePath, file_get_contents($file));
        }
        else
        {
          return redirect()->route('/');
        }
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->cover_img = $filePath;
        $blog->category_id = $request->category;
        $blog->user_id = Auth::id();
        $blog->content = $request->content;
        $blog->save();
        return redirect()->route('home');
    }

    public function deleteBlog($blog_id) {
        $blog = Blog::findOrFail($blog_id);
        if ($blog->user_id == Auth::id()) {
            $blog->delete();
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    public function editBlog($blog_id) {
        $blog = Blog::findOrFail($blog_id);
        if ($blog->user_id == Auth::id()) {
            return view('edit-blog',compact('blog'));
        }
        return redirect()->back();
    }

    public function updateBlog(Request $request) {
        if ($request->exists('id')) {
            $blog = Blog::findOrFail($request->id);
            if ($blog->user_id == Auth::id()) {
                $filePath = $blog->cover_img;
                if($request->hasFile('cover_img'))
                {
                  // Get filename with the extension
                  $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
                  // Get just filename
                  $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                  // Get just ext
                  $extension = $request->file('cover_img')->getClientOriginalExtension();
                  // Filename to store
                  $fileNameToStore= $filename.'_'.time().'.'.$extension;
                  $filePath = 'cover_img/' . $fileNameToStore;
                  // Upload Image
                  $file = $request->file('cover_img');
                  Storage::disk('public')->put($filePath, file_get_contents($file));
                }
                $blog->title = $request->title;
                $blog->cover_img = $filePath;
                $blog->category_id = $request->category;
                $blog->content = $request->content;
                $blog->update();
                return redirect()->route('single-blog',$blog->id);
            }
        }
        return redirect()->back();
    }

    public function aboutUs() {
        return view('about-us');
    }
}

