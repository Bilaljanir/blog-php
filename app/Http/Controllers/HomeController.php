<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {

        $categories = Category::take(6)->get();
        $posts = Post::published()->simple()->latest()->paginate(9);
        $postsPremium = Post::published()->premium()->latest()->get();
        return view('home')->with([
            'categories' => $categories,
            'posts' => $posts,
            'postsPremium' => $postsPremium
        ]);
    }

    public function postsByCategory(Category $category): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('home')->with([
            'posts' => $category->posts()->paginate(10),
            'category' => $category,
        ]);
    }
    public function postsByTag(Tag $tag): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('home')->with([
            'posts' => $tag->posts()->paginate(6),
            'tags' => $tag
        ]);
    }
    public function changeLang($lang): \Illuminate\Http\RedirectResponse
    {
        session()->forget('lang');
        session()->put('lang', $lang);
        return redirect()->back();
    }

public function searchByTerm(Request $request){
    $posts = Post::orderBy('created_at','desc')
        ->where('title_en', 'like', '%'.$request->term.'%')
        ->orWhere('title_fr', 'like', '%'.$request->term.'%')
        ->published()->get();
    return response()->json($posts);

}
}
