<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SlugGenerete;

class Article extends Model
{
    use HasFactory, HasUuids, SlugGenerete;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'category_id',
        'user_id',
        'title',
        'slug',
        'image',
        'body'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'category_id' => 'string',
        'user_id' => 'string',
        'title' => 'string',
        'slug' => 'string',
        'image'=> 'string',
        'body' => 'string'
    ];

    /**
     * Get atribut category data
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get atribut user data
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
