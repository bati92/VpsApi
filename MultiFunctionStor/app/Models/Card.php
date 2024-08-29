<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];
    
    /**
     * Get the user that owns the turkification.
     */
    public function user(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
}
