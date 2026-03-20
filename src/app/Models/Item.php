<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'description',
        'price',
        'image',
        'condition_id',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
        'price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
}
