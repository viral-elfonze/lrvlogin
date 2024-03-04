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
     * Store a newly created employee image or employee resume.
     */
    public function saveEmployeeImage(Request $request, String $value)
    {
        $request->validate([
            'employee_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $value == 'employee_image' ? $request->file('employee_image') : $request->file('resumelink');
        $savedfile = $this->ImageService->saveImage($file);

        // Return success response after saving employee image
        return response()->json(['message' => 'Employee image saved successfully', 'data' => $savedfile]);
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
            'employee_code' => 'required|unique:employee_details',
            'employement_type' => 'required',
            'relevantexp' => 'required',
            'totalexp' => 'required',
            'location' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'nullable|date',
            'resumelink' => 'required',
            'employee_image_id' => 'required',
            'isactive' => 'required',
        ]);

        if ($request->hasFile('employee_image_id')) {
            $savedFile = $this->saveEmployeeImage($request, 'image');
        }

        if ($request->hasFile('resume')) {
            $savedFile = $this->saveEmployeeImage($request, 'resume');
        }

        $employee = new EmployeeDetails();
        $employee->employee_firstname = $request->input('employee_firstname');
        $employee->employee_middlename = $request->input('employee_middlename');
        $employee->employee_lastname = $request->input('employee_lastname');
        $employee->employee_code = $request->input('employee_code');
        $employee->employement_type = $request->input('employement_type');
        $employee->relevantexp = $request->input('relevantexp');
        $employee->totalexp = $request->input('totalexp');
        $employee->location = $request->input('location');
        $employee->startdate = $request->input('startdate');
        $employee->enddate = $request->input('enddate');
        $employee->resume = $request->input('resume');
        $employee->employee_image = $savedFile;
        $employee->isactive = $request->input('isactive');
        $employee->save();

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
            'employee_id' => 'required|unique:employee_details,emp_id,' . $EmployeeDetails->id,
            'employee_code' => 'required|unique:employee_details,emp_code,' . $EmployeeDetails->id,
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
            $this->saveEmployeeImage($request, 'image');
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
