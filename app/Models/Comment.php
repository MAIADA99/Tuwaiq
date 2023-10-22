<?php

namespace App\Models;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function Blog():BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
