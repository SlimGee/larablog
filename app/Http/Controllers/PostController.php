<?php

namespace App\Http\Controllers;

use App\Enums\Post\Status;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Contracts\Support\Renderable;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): mixed
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate();

        return respond_to(fn($format) => match ($format) {
            'json' => PostResource::collection($posts),
            'html' => view('posts.index', [
                'posts' => $posts,
            ]),
        });
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
    public function store(StorePostRequest $request): mixed
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public');
        }

        $post = auth()->user()->posts()->create($data);

        return respond_to(fn($format) => match ($format) {
            'json' => PostResource::make($post),
            'html' => to_route('posts.show', $post),
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): mixed
    {
        return respond_to(fn($format) => match ($format) {
            'json' => PostResource::make($post),
            'html' => view('posts.show', [
                'post' => $post,
            ])
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): mixed
    {
        return view('posts.edit', [
            'statuses' => Status::cases(),
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): mixed
    {
        $post->fill($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('public');
        }

        $post->save();

        return respond_to(fn($format) => match ($format) {
            'json' => PostResource::make($post->fresh()),
            'html' => to_route('posts.show', $post),
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): mixed
    {
        $post->delete();

        return respond_to(fn($format) => match ($format) {
            'json' => response()->noContent(),
            'html' => to_route('posts.index'),
        });
    }
}
