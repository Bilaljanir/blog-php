<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware('admin')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        //
        $posts = Post::latest()->paginate(10);
        return view('admin.index')->with([
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        //
        return view('admin.posts.create')->with([
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePostRequest $request)
    {
        //
        if($request->validated()){
            $data = $request->except('_token');
            $file = $request->file('photo');
            $image_name = time().'_'.'photo'.'_'.$file->getClientOriginalName();
            $file->move('uploads', $image_name);
            $data['photo'] = 'uploads/'.$image_name;
            $data['slug'] = Str::slug($request->title_en);
            $data['admin_id'] = auth()->guard('admin')->user()->id;
            $post = Post::create($data);
            $post->tags()->sync($request->tags);
            return redirect()->route('posts.index')->with([
                'success' => 'Post added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Post $post)
    {
        //
        $next = Post::where('id', '>', $post->id )->orderBy('id')->first();
        $previous = Post::where('id', '<', $post->id )->orderBy('id', 'desc')->first();
        return view('post.show')->with([
            'post' => $post,
            'next' => $next,
            'previous' => $previous
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(Post $post)
    {
        //
        return view('admin.posts.edit')->with([
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
        if($request->validated()){
            $data = $request->except('_token');
            if($request->has('photo')){
                if(File::exists($post->photo)){
                    File::delete($post->photo);
                }
                $file = $request->file('photo');
                $image_name = time().'_'.'photo'.'_'.$file->getClientOriginalName();
                $file->move('uploads', $image_name);
                $data['photo'] = 'uploads/'.$image_name;
            }
            $data['slug'] = Str::slug($request->title_en);
            $data['admin_id'] = auth()->guard('admin')->user()->id;
            $post->update($data);
            $post->tags()->sync($request->tags);
            return redirect()->route('posts.index')->with([
                'success' => 'Post updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        //
        if(File::exists($post->photo)){
            File::delete($post->photo);
        }
        $post->delete();
        return redirect()->route('posts.index')->with([
            'success' => 'Post deleted successfully'
        ]);
    }

    public function indexFavorites()
    {
        $favorites = auth()->user()->favorites;

        return view('favorites', compact('favorites'));
    }

    public function Favorites($postId)
    {
        $post = Post::find($postId);
        $user = auth()->user();

        if ($post && $user) {
            $user->favorites()->attach($post->id);
        }

        return redirect()->back();
    }


}
