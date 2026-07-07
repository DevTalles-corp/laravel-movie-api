<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Genre extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','slug','description','is_active'];
    protected $casts = [
        'is_active'=> 'boolean',
    ];

     protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Genre $genre) {
            if(empty($genre->slug))
                {
                    $genre->slug = Str::slug($genre->name);
                }
        });

        static::updating(function (Genre $genre) {
            if($genre->isDirty('name'))
                {
                    $genre->slug = Str::slug($genre->name);
                }
        });
    }
    public function movies():BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
