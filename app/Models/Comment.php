<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pet_image_id'
    ];

    public function petImage()
    {
        return $this->belongsTo(PetImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
