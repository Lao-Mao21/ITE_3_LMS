<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publication_year',
        'category_id', // Nullable foreign key
        'publisher',
        'page_count',
        'language',
        'is_available',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'page_count' => 'integer',
        'is_available' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
        return $this->hasMany(Category::class);
    }
}
