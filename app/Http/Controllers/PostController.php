<?php

namespace App\Http\Controllers;

use App\Enums\Post\Status;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        return view('posts.create', [
            'statuses' => Status::cases(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $request->whenFilled('image', function ($image) use ($data) {
            $data['image'] = $image->store('public');
        });

        $post = auth()->user()->posts()->create($data);

        return to_route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Renderable
    {
        return view('posts.show', $post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Renderable
    {
        return view('posts.edit', [
            'statuses' => Status::cases(),
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $post->fill($request->safe()->except('image'));

        $request->whenFilled('image', function ($image) use ($post) {
            $post->image = $image->store('public');
        });

        $post->save();

        return to_route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return to_route('posts.index');
    }
}
