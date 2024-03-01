<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeDetails;

class EmployeeDetailsController extends Controller
{
    protected $ImageService;

    public function __construct(ImageService $ImageService)
    {
        $this->ImageService = $ImageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function getEmployeeDetails()
    {
        $employeesData = EmployeeDetails::all();

        // Return JSON response with a message
        return response()->json([
            'message' => 'Employees data retrieved successfully.',
            'data' => $employeesData,
        ]);
    }

    /**
     * Display a listing of the skills.
     */
    public function getEmployeeSkills()
    {
        $skillsData = Skills::all();

        // Return JSON response with a message
        return response()->json([
            'message' => 'Employees skills data retrieved successfully.',
            'data' => $skillsData,
        ]);
    }

    /**
     * Store a newly created employee image.
     */
    public function saveEmployeeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $this->ImageService->saveImage($file);

        // Return success response after saving employee image
        return response()->json(['message' => 'Employee image saved successfully']);
    }

    /**
     * Store a newly created employee details.
     */
    public function saveEmployeeDetail(Request $request)
    {
        $request->validate([
            'employee_firstname' => 'required',
            'employee_middlename' => 'required',
            'employee_lastname' => 'required',
            'employee_id' => 'required|unique:employee_profiles',
            'employee_code' => 'required|unique:employee_profiles',
            'employement_type' => 'required',
            'relevantexp' => 'required',
            'totalexp' => 'required',
            'location' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date',
            'resumelink' => 'nullable',
            'isactive' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $this->saveEmployeeImage($request);
        }

        EmployeeDetails::create($request->all());

        // Return success response after saving employee data
        return response()->json(['message' => 'Employee details saved successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function showEmployeeDetail(EmployeeDetails $EmployeeDetails)
    {
        return response()->json(['employeeData' => $EmployeeDetails]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeDetail(Request $request, EmployeeDetails $EmployeeDetails)
    {
        $request->validate([
            'employee_firstname' => 'required',
            'employee_middlename' => 'required',
            'employee_lastname' => 'required',
            'employee_id' => 'required|unique:employee_profiles,emp_id,' . $EmployeeDetails->id,
            'employee_code' => 'required|unique:employee_profiles,emp_code,' . $EmployeeDetails->id,
            'employement_type' => 'required',
            'relevantexp' => 'required',
            'totalexp' => 'required',
            'location' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date',
            'resumelink' => 'nullable',
            'isactive' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $this->saveEmployeeImage($request);
        }

        $EmployeeDetails->update($request->all());

        // Return the image path or URL
        return response()->json(['message' => 'Employee details update successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeEmployeeDetail(EmployeeDetails $EmployeeDetails)
    {
        $EmployeeDetails->delete();

        return response()->json(null, 204);
    }

    /**
     * Verify employee id is exists or not.
     */
    public function verifyemployee_id($employee_id)
    {
        // Implement logic to check if the employee ID exists in the database
        $employeeExists = EmployeeDetails::where('employee_id', $employee_id)->exists();

        // Return response based on the result
        return response()->json(['employeeexists' => $employeeExists]);
    }

    /**
     * Verify employee code is exists or not.
     */
    public function verifyemployee_code($employee_code)
    {
        // Implement logic to check if the employee ID exists in the database
        $employeeExists = EmployeeDetails::where('employee_code', $employee_code)->exists();

        // Return response based on the result
        return response()->json(['employee_codeexists' => $employeeExists]);
    }

    /**
     * Display a listing of the all locations.
     */
    public function getLocations()
    {
        $location = Locations::all();

        // Return JSON response with a message
        return response()->json([
            'message' => 'Locations retrieved successfully.',
            'data' => $location,
        ]);
    }
}
