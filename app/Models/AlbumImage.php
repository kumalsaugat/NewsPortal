<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'image_name',
        'caption',
        'cover_image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
