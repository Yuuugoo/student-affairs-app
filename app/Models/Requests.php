<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Requests extends Model
{
    use HasFactory;

    protected $fillable = ['org_name','status', 'submitted_by'];
    protected $casts =[
        'created_at' => 'datetime',
        'status' => Status::class
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    protected static function booted()
    {
        static::creating(function ($requests) {
            $requests->submitted_by = Auth::id();
        });
    }


}
