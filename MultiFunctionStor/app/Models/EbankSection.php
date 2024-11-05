<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbankSection extends Model
{
    use HasFactory;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
  
     protected $fillable = [
        'name',
        'image',
      
    ];

      /**
     * Get the user that owns the turkification.
     */
    public function ebanks(): BelongsTo
    {
        return $this->belongsTo(ebank::class);
    }
}
 