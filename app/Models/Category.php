<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    //One-to-Many relationship with Books
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    //book count
    public function getBooksCountAttribute(): int
    {
        return $this->books()->count();
    }

    //books with categories
    public function scopeHasBooks($query)
    {
        return $query->whereHas('books');
    }

    //search categories
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }
}
