<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudAffairsAccreditations extends Model
{
    use HasFactory;

    protected $primaryKey = 'accred_no';

    protected $fillable = [
        'accred_no', 'prepared_by', 'org_name', 'request_for_accred',
        'list_members_officers', 'const_by_laws', 'proof_of_acceptance',
        'calendar_of_projects', 'cert_of_grades', 'stud_enroll_rec', 'status',
        'req_type', 'remarks'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'list_members_officers' => 'array',
        'status' => Status::class,
        'remarks' => 'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'prepared_by')->with('Accreditation');
    }

    public function reaccreditation(){
        return $this->hasOne(StudAffairsReaccreditations::class, 'org_name_no');
    }

    public function requestactin()
    {
        return $this->hasOne(StudAffairsRequestsactins::class, 'org_name_no', 'accred_no');
    }

    public function requestactoff(){
        return $this->hasOne(StudAffairsRequestsactoffs::class, 'org_name_no');
    }

    protected static function booted()
    {
        static::creating(function ($accreditation) {
            $accreditation->prepared_by = Auth::id();
        });
    }
}
