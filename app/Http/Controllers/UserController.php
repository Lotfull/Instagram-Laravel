<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Follow;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;

function generate()
{
    if (User::all()->count() < 2) {
        factory(User::class, 4)->make()->map->save();
        factory(Post::class, 20)->make()->map->save();
        factory(Comment::class, 10)->make()->map->save();
        factory(Like::class, 3)->make()->map->save();
        factory(Follow::class, 2)->make()->map->save();
    }
}

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        generate();
        $posts = auth()->check() ? auth()->user()->feed() : Post::take(10)->get();
//        dump($posts);
        return view('main', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('main', [
            'posts' => $user->posts()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function follow(User $user)
    {
        Follow::create([
            'user_id' => auth()->user(),
            'following_user' => $user->id
        ]);
    }

    public function unfollow(Follow $follow)
    {
        if ($follow->user_id == auth()->user()->id)
            $follow->delete();
    }

    public function followers()
    {
        $followers = auth()->user()->followers();
        return view('users', [
            'name' => 'followers',
            'users' => $followers
        ]);
    }

    public function following()
    {
        $following = auth()->user()->following();
        return view('users', [
            'name' => 'following',
            'users' => $following
        ]);
    }
}