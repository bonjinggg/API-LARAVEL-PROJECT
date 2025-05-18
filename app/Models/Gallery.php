<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $primaryKey = 'gallery_id';

    protected $fillable = [
        'name',
        'image',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'gallery_id');
    }
}
