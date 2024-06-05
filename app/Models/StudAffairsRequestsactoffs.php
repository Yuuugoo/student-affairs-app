<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudAffairsRequestsactoffs extends Model
{
    use HasFactory;
    protected $primaryKey = 'act_off_no';

    protected $fillable = ['act_off_no','csw', 'prepared_by', 'status', 'org_name', 'req_type',
                            'start_date', 'end_date', 'title', 'venues', 'participants_no', 'remarks', 'maximum_capacity'];
    protected $casts =[
        'created_at' => 'datetime',
        'status' => Status::class,
        'remarks' => 'array'
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

}
