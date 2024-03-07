<?php

namespace App\Http\Controllers;

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
                'employee_id' => 'required',
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

            EmployeeSkillMatrix::create($request->all());

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
                'employee_id' => 'required',
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
                return response()->json(['status' => 'error', 'message' => 'Employee skill data not found', 'data' => []]);
            }

            $employeeSkills->update($request->all());

            // Return success response after saving employee skill matrix data
            return response()->json(['status' => 'success', 'message' => 'Employee skill matrix updated successfully']);
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
                return response()->json(['status' => 'error', 'message' => 'Employee skill data not found', 'data' => []]);
            }

            // Delete employee skill record
            $employeeSkill->delete();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Employee skill data deleted successfully']);
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
    public function getMySkills($id)
    {
        try {
            $employeeSkillMatrix = EmployeeSkillMatrix::with('skills')->where('employee_id', $id)->first();

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
     * Display a listing of the employee skill matrix.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeSkillMatrix(Request $request)
    {
        // Start with a query to retrieve all employees kill matrix
        $employeesSkills = EmployeeSkillMatrix::query();

        // Apply filters if provided in the request
        if ($request->has('skill_id')) {
            $employeesSkills->where('skill_id', $request->skill_id);
        }

        // Retrieve the filtered employees data
        $employees = $employeesSkills->get();

        // Return JSON response with a message
        return response()->json([
            'status' => 'success',
            'message' => 'All Employee skills data retrieved successfully.',
            'data' => $employees,
        ]);
    }
}
