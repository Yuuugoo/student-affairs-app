<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reaccreditation extends Model
{
    protected $primaryKey = 'reaccred_no';

    protected $fillable = ['reaccred_no','prepared_by', 'org_name_no', 'request_for_accred',
    'list_members_officers', 'const_by_laws', 'proof_of_acceptance',
    'calendar_of_projects', 'cert_of_grades', 'stud_enroll_rec', 'status',
    'req_type'];

    protected $casts =[
        'created_at' => 'datetime',
        'status' => Status::class,
        'list_members_officers' => 'array'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class, 'org_name_no', 'accred_no');
    }

    protected static function booted()
    {
        static::creating(function ($request) {
            $request->prepared_by = Auth::id();

            $accreditation = Accreditation::where('prepared_by', Auth::id())->first();

            if ($accreditation) {
                $request->org_name_no = $accreditation->accred_no;
            }
        });
    }


    
}
