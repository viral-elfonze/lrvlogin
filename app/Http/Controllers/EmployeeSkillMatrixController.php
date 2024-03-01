<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSkillMatrix;
use App\Models\Skills;
use Illuminate\Http\Request;

class EmployeeSkillMatrixController extends Controller
{
    /**
     * Display a listing of the employee skills.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeSkillMatrix(Request $request)
    {
        // Start with a query to retrieve all employees kill matrix
        $employeesskills = EmployeeSkillMatrix::query();

        // Apply filters if provided in the request
        if ($request->has('skill_id')) {
            $employeesskills->where('skill_id', $request->skill_id);
        }

        // Retrieve the filtered employees data
        $employees = $employeesskills->get();

        // Return JSON response with a message
        return response()->json([
            'message' => 'All Employee skills data retrieved successfully.',
            'data' => $employees,
        ]);
    }

    /**
     * Display a listing of the skills.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllSkills()
    {
        // Retrieve all skills from the database
        $skills = Skills::all();

        // Return JSON response with a message
        return response()->json([
            'message' => 'All skills data retrieved successfully.',
            'data' => $skills,
        ]);
    }

    /**
     * Store a newly created employee skills.
     */
    public function saveEmployeeSkillMatrix(Request $request)
    {
        $request->validate([
            'skill_id' => 'required',
            'employee_id' => 'required',
            'relevantexp' => 'required',
            'competency' => 'required'
        ]);

        EmployeeSkillMatrix::create($request->all());

        // Return success response after saving employee skill matrix data
        return response()->json(['message' => 'Employee skill matrix saved successfully']);
    }

    /**
     * Display the specified employee matrix resource.
     */
    public function showEmployeeSkillMatrix(EmployeeSkillMatrix $EmployeeSkills)
    {
        return response()->json(['employeeSkills' => $EmployeeSkills]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeSkillMatrix(Request $request, EmployeeSkillMatrix $EmployeeSkills)
    {
        $request->validate([
            'skill_id' => 'required',
            'employee_id' => 'required',
            'relevantexp' => 'required',
            'competency' => 'required'
        ]);

        $EmployeeSkills->update($request->all());

        // Return success response after saving employee skill matrix data
        return response()->json(['message' => 'Employee skill matrix updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeEmployeeSkillMatrix(EmployeeSkillMatrix $EmployeeSkill)
    {
        $EmployeeSkill->delete();

        return response()->json(null, 204);
    }
}
