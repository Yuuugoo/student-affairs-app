<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'content','image_preview', 'publish'];
    protected $casts =[
        'created_at' => 'datetime',
    ];
  

}


