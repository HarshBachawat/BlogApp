<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Category;
use App\User;
use Auth;
use Storage;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['singleBlog','welcome','aboutUs']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function welcome(Request $request) {
        $banner = 1;
        $blogs = Blog::select('blogs.*','categories.title as cat_title','users.name as username')
                ->leftJoin('categories','blogs.category_id','=','categories.id')
                ->leftJoin('users','blogs.user_id','=','users.id')
                ->orderBy('created_at','DESC');

        if (isset($request->search)) {
            $banner = 0;
            $search = strtolower($request->search);
            $blogs = $blogs->where(function ($query) use ($search) {
                $query->orWhere('blogs.title','like','%'.$search.'%')
                ->orWhere('categories.title','like','%'.$search.'%')
                ->orWhere('users.name','like','%'.$search.'%');
            });
        }
        elseif (isset($request->category)) {
            $banner = 0;
            $category = $request->category;
            $blogs = $blogs->where(function ($query) use ($category) {
                $query->orWhere('blogs.category_id','=',$category);
            });
        }

        if (isset($request->page) && $request->page>1) {
            $banner = 0;
        }
        $blogs = $blogs->paginate('3');
        return view('welcome',compact('blogs','banner'));
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

    public function editProfile() {
        return view('edit-profile');
    }

    public function updateProfile(Request $request) {
        $filePath = Auth::user()->profile_img;
        if($request->hasFile('profile_img'))
        {
          // Get filename with the extension
          $filenameWithExt = $request->file('profile_img')->getClientOriginalName();
          // Get just filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          // Get just ext
          $extension = $request->file('profile_img')->getClientOriginalExtension();
          // Filename to store
          $fileNameToStore= $filename.'_'.time().'.'.$extension;
          $filePath = 'profile_img/' . $fileNameToStore;
          // Upload Image
          $file = $request->file('profile_img');
          Storage::disk('public')->put($filePath, file_get_contents($file));
        }
        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile_img = $filePath;
        $user->description = $request->description;
        $user->update();
        return redirect()->route('home');
    }

    public function updatePassword(Request $request) {
        $new_password = $request->newPassword;
        $cnf_password = $request->confirmPassword;
        if(Hash::check($request->currentPassword, Auth::user()->password)){
            if($new_password == $cnf_password){
                Auth::user()->password = Hash::make($request['current_password']);
                Auth::user()->save();
                return redirect('edit-profile');
                // $data['msg_type'] = "Success";
                // $data['msg'] = "Password Changed Successfully";
            }
            // else{
                // $data['msg_type'] = "error";
                // $data['msg'] = "Password and Confirm Password is not Same";
            // }
        }
        // else{
            // $data['msg_type'] = "error";
            // $data['msg'] ="Current password is Incorrect";
        // }
        return redirect()->back();
    }

    public function aboutUs() {
        return view('about-us');
    }
}

