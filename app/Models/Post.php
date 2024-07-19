<?php

namespace App\Models;

use App\Enums\Post\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that should not be mass assignable
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types
     *
     * @var<string, string>
     */
    protected function casts()
    {
        return [
            'status' => Status::class,
        ];
    }

    /**
     * Get the user that owns the post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
