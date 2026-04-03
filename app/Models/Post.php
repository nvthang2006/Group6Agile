<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::disk('public')->exists($this->image)
            ? route('media.file', ['path' => $this->image])
            : null;
    }
}
