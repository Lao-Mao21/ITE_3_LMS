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

    /**
     * Many-to-One relationship with Category
     * Book belongs to a Category (optional - nullable)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    //scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
    public function scopeUnavailable($query)
    {
        return $query->where('is_available', false);
    }
    public function scopeUncategorized($query)
    {
        return $query->whereNull('category_id');
    }

    //book search
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%")
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
    }

    //Alias for uncategorized
    public function getCategoryNameAttribute(): string
    {
        return $this->category ? $this->category->name : 'Uncategorized';
    }

    //if book = no category
    public function getIsUncategorizedAttribute(): bool
    {
        return is_null($this->category_id);
    }
}
