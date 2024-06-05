<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudAffairsCalendar extends Model
{
    use HasFactory;


    protected $fillable = [
        'id', 'prepared_by', 'start_date', 'end_date', 'title', 'org_name'
    ];

    protected $casts =[
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function accreditation()
    {
        return $this->belongsTo(StudAffairsAccreditations::class, 'org_name_no', 'accred_no');
    }

    protected static function booted()
    {
        static::creating(function ($request) {
            $request->prepared_by = Auth::id();

            $accreditation = StudAffairsAccreditations::where('prepared_by', Auth::id())->first();

            if ($accreditation) {
                $request->org_name_no = $accreditation->accred_no;
            }
        });
    }

    public function requestsActIns()
    {
        return $this->hasMany(StudAffairsRequestsactins::class, 'calendar_id');
    }

    public function requestsActOffs()
    {
        return $this->hasMany(StudAffairsRequestsactoffs::class, 'calendar_id');
    }
}
