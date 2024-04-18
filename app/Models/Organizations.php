<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organizations extends Model
{
    use HasFactory;

    protected $fillable = [ 'org_name', 'org_logo'];

    protected $casts =[
        'created_at' => 'datetime',
    ];

    public function accred()
    {
        return $this->belongsTo(Accreditation::class, 'org_name');
    }

    protected static function booted()
    {
        static::creating(function ($requests) {
            $requests->org_name = Auth::id();
        });
    }

}
