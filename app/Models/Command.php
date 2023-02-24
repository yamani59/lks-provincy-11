<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'article_id',
        'body'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'article_id' => 'string',
        'body' => 'string'
    ];

    /**
     * Get atribut user data
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get atribut article data
     */
    public function article()
    {
        return $this->hasOne(Article::class);
    }
}
