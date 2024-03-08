<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSkillMatrix extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_skill_matrix';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'skill_id', 'employee_id', 'relevantexp', 'competency'
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

    public function skills()
    {
        return $this->belongsTo(Skills::class, 'skill_id');
    }

    public function employeeDetails()
    {
        return $this->belongsTo(EmployeeDetails::class, 'employee_id');
    }

    public function employeeCertifications()
    {
        return $this->hasMany(EmployeeCertification::class, 'employee_skill_matrix_id');
    }
}
