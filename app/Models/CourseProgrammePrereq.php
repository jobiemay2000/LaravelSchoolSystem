<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class CourseProgrammePrereq extends Model
{



    public $table = 'CourseProgrammePrereq';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


  



    public $fillable = [
        'course_programme_id',
        'prereq_course_programme_id'
    ];


    public static $rules = [
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'course_programme_id' => 'required',
        'prereq_course_programme_id' => 'required'
    ];

    public function CourseProgramme()
    {
        return $this->belongsTo(CourseProgramme::class, 'course_programme_id');
    }

    public function PrereqProg() //prereq subject details
    {
        return $this->belongsTo(CourseProgramme::class, 'prereq_course_programme_id', 'id');
    }
}
