<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_deleted',
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

    public function students()
    {
        return $this->hasMany(Student::class);
    } 

    /**
     * Scope a query to only include non-deleted categories.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_deleted', false);
    }

    /**
     * Scope a query to only include deleted categories.
     */
    public function scopeDeleted(Builder $query): void
    {
        $query->where('is_deleted', true);
    }
}
