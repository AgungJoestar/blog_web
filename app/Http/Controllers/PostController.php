<?php

namespace App\Http\Controllers;

use App\Models\Post; //load post model
use App\Models\Category; //load category model
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::latest()->get();
        // $posts = Post::with('category')->get();
        $posts = Post::sortable()->paginate(5);
        $category = Category::latest()->get();

        return view('posts.index', compact('posts', 'category'));
        // return $posts;
    }

    public function create()
    {
        $category = Category::latest()->get();
        return view('posts.create', compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required',
            'category' => 'required'
        ]);

        $if_cat_null = $request->category;
        if($if_cat_null==0){
            $if_cat_null = NULL;
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'category' => $if_cat_null,
            'slug' => Str::slug($request->title)
        ]);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $category = Category::latest()->get();
        return view('posts.edit', compact('post', 'category'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:155',
            'content' => 'required',
            'status' => 'required',
            'category' => 'required'
        ]);

        $post = Post::findOrFail($id);

        $if_cat_null = $request->category;
        if($if_cat_null==0){
            $if_cat_null = NULL;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'category' => $if_cat_null,
            'slug' => Str::slug($request->title)
        ]);

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Post has been updated successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem has occured, please try again'
                ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('post.index')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('post.index')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.view_post', compact('post'));
    }

    public function search(Request $request)
    {
        // menangkap data pencarian
        $search = $request->search;
        $category = Category::latest()->get();
        $search_category = $request->search_category;
 
            // mengambil data dari table pegawai sesuai pencarian data
        // $posts = DB::table('posts')
        // ->where('title','like',"%".$search."%")
        // ->paginate();

        if($search_category >-1)
        {
            if($search_category == 0)
                $search_category = NULL;
            
            $posts = Post::sortable()->where('title','like',"%".$search."%")->where('category','=',$search_category)->paginate(5);
        }else
        {
            $posts = Post::sortable()->where('title','like',"%".$search."%")->paginate(5);
        }
            // mengirim data pegawai ke view index
        return view('posts.index', compact('posts', 'category'));
        // return $post;
 
    }
}

