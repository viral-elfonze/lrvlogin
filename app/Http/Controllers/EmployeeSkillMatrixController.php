<?php

namespace App\Http\Controllers;

use App\Models\EmployeeCertification;
use Exception;
use App\Models\Skills;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeSkillMatrix;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeSkillMatrixController extends Controller
{
    protected $ImageService;

    public function __construct(ImageService $ImageService)
    {
        $this->middleware('cors');
        $this->ImageService = $ImageService;
    }

    /**
     * Display a listing of the skills.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllSkills()
    {
        try {
            // Retrieve all skills from the database
            $skills = Skills::all();

            // If skill not found, return error response
            if (!$skills) {
                return response()->json(['status' => 'error', 'message' => 'Skills not found', 'data' => []]);
            }

            // Return JSON response with a message
            return response()->json([
                'status' => 'success',
                'message' => 'All skills data retrieved successfully.',
                'data' => $skills,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created employee image or employee resume.
     */
    public function saveCertificationImage($img, String $value)
    {
        $savedFile = $this->ImageService->saveImage($img, $value);

        // Return success response after saving employee image
        return response()->json(['status' => 'success', 'message' => 'Employee certificate saved successfully', 'data' => $savedFile]);
    }

    /**
     * Store a newly created employee skills.
     */
    public function saveEmployeeSkillMatrix(Request $request)
    {
        try {
            $rules = [
                'skill_id' => [
                    'required',
                    'exists:skills,skill_id',
                    Rule::unique('employee_skill_matrix')->where(function ($query) use ($request) {
                        return ($query->where('skill_id', $request->input('skill_id')) && $query->where('employee_id', $request->input('employee_id')));
                    }),
                ],
                'employee_id' => 'required|exists:employee_details,employee_id',
                'relevantexp' => 'required|integer|min:0',
                'competency' => 'required',
                'is_certificate' => 'boolean',
                'certificate' => 'array',
            ];

            // Validate the request data
            $validator = Validator::make($request->all(), $rules);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'data' => $validator->errors(),
                ]);
            }

            $savedImageFile = '';
            $empSkillObj = EmployeeSkillMatrix::create($request->all());

            if ($request->input('is_certificate') && !empty($request->input('certificates'))) {
                foreach ($request->input('certificates') as $index => $certificateData) {
                    $certificateValidator = Validator::make($certificateData, [
                        'certificates.*.name' => 'nullable|string',
                        'certificates.*.number' => 'nullable|string',
                        'certificates.*.description' => 'string|nullable',
                        'certificates.*.issue_date' => 'date|nullable',
                        'certificates.*.expiry_date' => 'date|nullable',
                        'certificates.*.certification_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);

                    if ($certificateValidator->fails()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Certificate Validation Error',
                            'data' => $certificateValidator->errors(),
                        ]);
                    }

                    if ($request->hasFile("certificates.$index.certification_image") && $request->file("certificates.$index.certification_image")->isValid()) {
                        $img = $request->file("certificates.$index.certification_image");
                        $savedImageFile = $this->saveCertificationImage($img, 'certification_image');
                    }

                    $employeeCertificate = new EmployeeCertification();
                    $employeeCertificate->employee_skill_matrix_id =  $empSkillObj->id;
                    $employeeCertificate->name = $certificateData['name'];
                    $employeeCertificate->number = $certificateData['number'];
                    $employeeCertificate->description = $certificateData['description'];
                    $employeeCertificate->issue_date = $certificateData['issue_date'];
                    $employeeCertificate->expiry_date = $certificateData['expiry_date'];
                    $employeeCertificate->certification_image = ($savedImageFile) ? $savedImageFile->getData()->data->id : null;
                    $employeeCertificate->save();
                }
            }
            // Return success response after saving employee skill matrix data
            return response()->json(['status' => 'success', 'message' => 'Employee skill matrix saved successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeSkillMatrix(Request $request, $employeeSkillId)
    {
        try {
            // Find employee by employee skill ID column
            $employeeSkills = EmployeeSkillMatrix::with('employeeCertifications')->where('id', $employeeSkillId)->first();

            $rules = [
                'skill_id' => 'required','exists:skills,skill_id',
                'employee_id' => 'required|exists:employee_details,employee_id',
                'relevantexp' => 'required|integer|min:0',
                'competency' => 'required',
                'is_certificate' => 'boolean',
                'certificate' => 'array',
            ];

            // Validate the request data
            $validator = Validator::make($request->all(), $rules);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'data' => $validator->errors(),
                ]);
            }

            // If employee skill data not found, return error response
            if (!$employeeSkills) {
                return response()->json(['status' => 'error', 'message' => 'Employee skill matrix data not found', 'data' => []]);
            }

            $empSkillObj = $employeeSkills->update($request->all());

            if ($request->input('is_certificate') && !empty($request->input('certificates'))) {
                foreach ($request->input('certificates') as $index => $certificateData) {
                    $certificateValidator = Validator::make($certificateData, [
                        'certificates.*.name' => 'nullable|string',
                        'certificates.*.number' => 'nullable|string',
                        'certificates.*.description' => 'string|nullable',
                        'certificates.*.issue_date' => 'date|nullable',
                        'certificates.*.expiry_date' => 'date|nullable',
                        'certificates.*.certification_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);

                    if ($certificateValidator->fails()) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Certificate Validation Error',
                            'data' => $certificateValidator->errors(),
                        ]);
                    }

                    if ($request->hasFile("certificates.$index.certification_image") && $request->file("certificates.$index.certification_image")->isValid()) {
                        $img = $request->file("certificates.$index.certification_image");
                        $savedImageFile = $this->saveCertificationImage($img, 'certification_image');
                    }

                    // Find the certificate by its ID
                    $employeeCertificate = $employeeSkills->employeeCertifications->get($index);
                    $employeeCertificate->update([
                        $employeeCertificate->employee_skill_matrix_id = (int)$employeeSkillId,
                        $employeeCertificate->name = $certificateData['name'],
                        $employeeCertificate->number = $certificateData['number'],
                        $employeeCertificate->description = $certificateData['description'],
                        $employeeCertificate->issue_date = $certificateData['issue_date'],
                        $employeeCertificate->expiry_date = $certificateData['expiry_date'],
                        $employeeCertificate->certification_image = ($savedImageFile) ? $savedImageFile->getData()->data->id : null
                    ]);
                }
            }

            // Return success response after saving employee skill matrix data
            return response()->json(['status' => 'success', 'message' => 'Employee skill matrix data updated successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeEmployeeSkillMatrix($id)
    {
        try {
            // Find employee by employee ID column
            $employeeSkill = EmployeeSkillMatrix::with('employeeCertifications')->where('id', $id)->first();

            if (!empty($employeeSkill['employeeCertifications'])) {
                foreach ($employeeSkill['employeeCertifications'] as $certificateData) {
                    // Delete employee certificate record
                    $certificateData->delete();
                }
            }

            // If employee skill not found, return error response
            if (!$employeeSkill) {
                return response()->json(['status' => 'error', 'message' => 'Employee skill matrix data not found', 'data' => []]);
            }

            // Delete employee skill record
            $employeeSkill->delete();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Employee skill matrix data deleted successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified employee matrix resource.
     */
    public function showEmployeeSkillMatrix($id)
    {
        try {
            $employeeSkillMatrix = EmployeeSkillMatrix::with(['Skills', 'EmployeeDetails','employeeCertifications'])->where('id', $id)->first();

            if (!$employeeSkillMatrix) {
                return response()->json(['status' => 'error', 'message' => 'Employee skill data not found', 'data' => []]);
            }

            return response()->json([['status' => 'success', 'message' => 'Employee skill data fetched successfully'], 'data' => $employeeSkillMatrix]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified employee skills resource.
     */
    public function getMySkills($employee_id)
    {
        try {
            $employeeSkillMatrix = EmployeeSkillMatrix::with(['skills'])->where('employee_id', $employee_id)->orderBy('competency', 'desc')->get();

            if (!$employeeSkillMatrix) {
                return response()->json(['status' => 'error', 'message' => 'My skills data not found', 'data' => []]);
            }

            return response()->json([['status' => 'success', 'message' => 'My skills data fetched successfully'], 'data' => $employeeSkillMatrix]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display a listing of the employee skill matrix with filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeSkillWithFilter(Request $request, $id)
    {
        // Start with a query to retrieve all employees kill matrix
        // $employeesSkills = EmployeeSkillMatrix::join('employee_details', 'employee_skill_matrix.employee_id', '=', 'employee_details.employee_id')
        //     ->join('skills', 'employee_skill_matrix.skill_id', '=', 'skills.skill_id')
        //     ->join('employee_certifications', 'employee_certifications.employee_skill_matrix_id', '=', 'employee_skill_matrix.id')
        //     ->select(
        //         'skills.skill',
        //         'employee_details.employee_id',
        //         'employee_details.employee_firstname',
        //         'employee_details.employee_lastname',
        //         'employee_details.resumelink',
        //         'employee_details.relevantexp',
        //         'employee_details.totalexp',
        //         'employee_certifications.*'
        //     )->where('employee_details.employee_id', $id);

        $employeesSkills = EmployeeSkillMatrix::with(['skills', 'employeeCertifications'])->where('employee_skill_matrix.employee_id', $id);
        // Apply sorting
        if ($request->has('sort_by')) {
            $employeesSkills->orderBy($request->input('sort_by'), $request->input('sort_order', 'asc'));
        }


        $employeesSkills = EmployeeSkillMatrix::with(['skills', 'employeeCertifications'])->where('employee_skill_matrix.employee_id', $id);
        if ($request->has('skill_set')) {
            $employeesSkills->whereHas('skills', function ($query) use ($request) {
                $query->where('skill', 'like', '%' . $request->input('skill_set') . '%');
            });
        }
        // Apply sorting
        if ($request->has('sort_by')) {
            $employeesSkills->orderBy($request->input('sort_by'), $request->input('sort_order', $request->input('order', 'asc')));
        }

        $page = $request->input('page', 1); // Default page number is 1
        $employees = $employeesSkills->paginate($request->input('per_page', 10), ['*'], 'page', $page);



        // Retrieve the filtered employees data
        // $employees = $employeesSkills->get();

        // Return JSON response with a message
        return response()->json([
            'status' => 'success',
            'message' => 'All Filtered Employee skills data retrieved successfully.',
            'data' => $employees,
        ]);
    }
}
