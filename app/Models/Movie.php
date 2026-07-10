<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title','sypnosis','is_active','year',
                           'rating','poster','duration','director'];
    protected $casts = [
        'is_active'=> 'boolean',
        'rating' => 'decimal:1',
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
        'deleted_at'=>'datetime',
    ];

     protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Movie $movie) {
            if(empty($movie->slug))
                {
                    $movie->slug = Str::slug($movie->title);
                }
        });

        static::updating(function (Movie $movie) {
            if($movie->isDirty('title'))
                {
                    $movie->slug = Str::slug($movie->title);
                }
        });
    }
    public function genres():BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}