<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'price',
        'note',
        'type',//فاتورة   1 :   ---   -2:رصيد
    ];
    
    /**
     * Get the user that owns the turkification.
     */
    public function user(): BelongsToMany
    {
        return $this->BelongsToMany(User::class);
    }
}