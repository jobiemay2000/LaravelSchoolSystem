<?php

namespace App\Models;

use Eloquent as Model;


/**
 * Class Programme
 * @package App\Models
 * @version July 29, 2021, 2:13 pm UTC
 *
 * @property string $name
 * @property string $code
 */
class Programme extends Model
{



    public $table = 'Programme';

    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key

    protected $primaryKey = 'progCode';
    public $incrementing = false;
    protected $keyType = 'string';


    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


   



    public $fillable = [
        'name',
        'progCode',
        'name',
        'level'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
        'progCode' => 'string',
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'name' => 'required|string|max:191',
        'progCode' => 'required|string|max:191'
    ];

    public function CourseProgramme()
    {
        return $this->hasMany(CourseProgramme::class, 'progCode');
    }
}
