<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeProfile;

class EmployeeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getEmployeeDetails()
    {
        $employeesData = EmployeeProfile::all();

         // Return JSON response with a message
         return response()->json([
            'message' => 'Employees data retrieved successfully.',
            'data' => $employeesData,
        ]);
    }

    /**
     * Store a newly created employee details.
     */
    public function saveEmployeeDetail(Request $request)
    {
        $request->validate([
            'employeefirstname' => 'required',
            'employeedmiddlename' => 'required',
            'employeelastname' => 'required',
            'employeeid' => 'required|unique:employee_profiles',
            'employeecode' => 'required|unique:employee_profiles',
            'employementtype' => 'required',
            'relevantexp' => 'required',
            'totalexp' => 'required',
            'location' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date',
            'resumelink' => 'nullable',
            'isactive' => 'required',
        ]);

        EmployeeProfile::create($request->all());

        // Return success response after saving employee data
        return response()->json(['message' => 'Employee details saved successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function showEmployeeDetail(EmployeeProfile $employeeProfile)
    {
        return response()->json(['employeeData' => $employeeProfile]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeDetail(Request $request, EmployeeProfile $employeeProfile)
    {
        $request->validate([
            'employeefirstname' => 'required',
            'employeedmiddlename' => 'required',
            'employeelastname' => 'required',
            'employeeid' => 'required|unique:employee_profiles,emp_id,' . $employeeProfile->id,
            'employeecode' => 'required|unique:employee_profiles,emp_code,' . $employeeProfile->id,
            'employementtype' => 'required',
            'relevantexp' => 'required',
            'totalexp' => 'required',
            'location' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date',
            'resumelink' => 'nullable',
            'isactive' => 'required',
        ]);

        $employeeProfile->update($request->all());

        // Return the image path or URL
        return response()->json(['message' => 'Employee details update successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeEmployeeDetail(EmployeeProfile $employeeProfile)
    {
        $employeeProfile->delete();

        return response()->json(null, 204);
    }
}
