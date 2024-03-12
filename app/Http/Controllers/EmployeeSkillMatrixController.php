<?php

namespace App\Http\Controllers;

use App\Models\EmployeeCertification;
use Exception;
use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\EmployeeSkillMatrix;
use Illuminate\Support\Facades\Validator;

class EmployeeSkillMatrixController extends Controller
{
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
     * Store a newly created employee skills.
     */
    public function saveEmployeeSkillMatrix(Request $request)
    {
        try {
            $rules = [
                'skill_id' => 'required|exists:skills,skill_id',
                'employee_id' => 'required|exists:employee_details,employee_id',
                'relevantexp' => 'required|integer|min:0',
                'competency' => 'required',
                'is_certificate'=>'boolean',
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

            $empSkillObj  = EmployeeSkillMatrix::create($request->all());

            if($request->input('is_certificate')){
                //array loop
                // get the cerificate of the skill
                if ($request->hasFile('certification_image')) {
                    $savedImageFile = $this->saveCertificationImage($request, 'certification_image');
                }

                $employeeCertificate = new EmployeeCertification();
                $employeeCertificate->employee_skill_matrix_id =  $empSkillObj->id;
                $employeeCertificate->name = $request->input('name');
                $employeeCertificate->number = $request->input('number');
                $employeeCertificate->description = $request->input('description');
                $employeeCertificate->issue_date = $request->input('issue_date');
                $employeeCertificate->expiry_date = $request->input('expiry_date');
                $employeeCertificate->certification_image = ($savedImageFile) ? $savedImageFile->getData()->data->id : null;
                $employeeCertificate->save();
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
            $employeeSkills = EmployeeSkillMatrix::where('id', $employeeSkillId)->first();

            $rules = [
                'skill_id' => 'required|exists:skills,skill_id',
                'employee_id' => 'required|exists:employee_details,employee_id',
                'relevantexp' => 'required|integer|min:0',
                'competency' => 'required'
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

            $employeeSkills->update($request->all());

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
            $employeeSkill = EmployeeSkillMatrix::where('id', $id)->first();

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
            $employeeSkillMatrix = EmployeeSkillMatrix::with(['Skills', 'EmployeeDetails'])->where('id', $id)->first();

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
            $employeeSkillMatrix = EmployeeSkillMatrix::with(['skills', 'EmployeeDetails'])->where('employee_id', $employee_id)->get();

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
    public function getEmployeeSkillWithFilter(Request $request)
    {
        // Start with a query to retrieve all employees kill matrix
        $employeesSkills = EmployeeSkillMatrix::with(['skills', 'EmployeeDetails']);

        // Apply sorting
        if ($request->has('sort_by')) {
            $employeesSkills->orderBy($request->input('sort_by'), $request->input('sort_order', 'asc'));
        }

        // Apply filter
        if ($request->has('skill_set')) {
            $employeesSkills->whereHas('skills', function ($query) use ($request) {
                $query->where('skill', 'like', '%' . $request->input('skill_set') . '%');
            });
        }

        // Retrieve the filtered employees data
        $employees = $employeesSkills->get();

        // Return JSON response with a message
        return response()->json([
            'status' => 'success',
            'message' => 'All Filtered Employee skills data retrieved successfully.',
            'data' => $employees,
        ]);
    }
}
