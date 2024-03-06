<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetails extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_details';

    protected $primaryKey = 'employee_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_code', 'employee_firstname', 'employee_middlename', 'employee_lastname', 'resumelink', 'employement_type', 'startdate', 'enddate', 'location', 'totalexp', 'relevantexp', 'isactive'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function imageMaster()
    {
        return $this->belongsTo(ImageMaster::class);
    }
}
