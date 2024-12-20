<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class EbankSection extends Model
{
    use HasFactory;
  
     protected $fillable = [
        'name',
        'image',
        'image_url',
        'status',
    ];

    public function ebanks(): HasMany
    {
        return $this->hasMany(Ebank::class, 'section_id');
    }
    
}
 