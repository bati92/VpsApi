<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCommunicationSection extends Model
{
    protected $fillable = [
        'name',
        'image',
        'image_url',
        'status',
    ];
    
    public function DataCommunications(): HasMany
    {
        return $this->hasMany(DataCommunication::class, 'section_id');
    }

}
