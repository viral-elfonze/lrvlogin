<?php

namespace App\Models;

use App\Services\ImageService;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeDetails extends Model
{
    use HasFactory;

    use SoftDeletes;

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
        'employee_code', 'user_id', 'employee_firstname', 'employee_middlename', 'employee_lastname', 'resumelink', 'employement_type', 'startdate', 'enddate', 'location', 'totalexp', 'relevantexp', 'isactive'
    ];

    protected $appends = ['full_name','resume_url','employeeimage_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // protected $ImageService;

    // public function __construct(ImageService $ImageService)
    // {
    //     $this->ImageService = $ImageService;
    // }
    public function employeeSkills()
    {
        return $this->hasMany(EmployeeSkillMatrix::class, 'id');
    }
    public function userObj()
    {
        return $this->hasOne(User::class,'id');
    }
    public function employeeSkillsId()
    {
        return $this->hasMany(EmployeeSkillMatrix::class, 'employee_id')
        ->join('skills', 'employee_skill_matrix.skill_id', '=', 'skills.skill_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->employee_firstname} {$this->employee_middlename}";
    }
    public function getResumeUrlAttribute()
    {
        $ImageService = Container::getInstance()->make(ImageService::class);
        $path = $ImageService->getImagePath($this->resumelink);
        return $path;
    }
    public function getEmployeeimageUrlAttribute()
    {
        $ImageService = Container::getInstance()->make(ImageService::class);
        $path = $ImageService->getImagePath($this->employee_image);
        return $path;

    }
}
