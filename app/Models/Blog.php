<?php

namespace App\Models;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function comments(): HasMany
    {
         //1-m  Blog have many comments
        return $this->hasMany(Comment::class);
    }
}
