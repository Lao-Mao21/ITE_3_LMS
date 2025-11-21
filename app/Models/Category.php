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

    public function students()
    {
        return $this->hasMany(Student::class);
    } 
}
