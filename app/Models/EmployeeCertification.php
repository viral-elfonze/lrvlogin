<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCertification extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_certifications';

    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'employee_skill_matrix_id', 'name', 'number', 'description', 'issue_date', 'expiry_date', 'certification_image'
    ];
    protected $appends = ['certification_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function employeeSkillMatrix()
    {
        return $this->belongsTo(EmployeeSkillMatrix::class, 'employee_skill_matrix_id');
    }
    public function getCertificationUrlAttribute()
    {
        $ImageService = Container::getInstance()->make(ImageService::class);
        $path = $ImageService->getImagePath($this->certification_image);
        return $path;
    }
}
