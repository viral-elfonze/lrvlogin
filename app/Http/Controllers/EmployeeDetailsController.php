<?php

namespace App\Http\Controllers;

use App\Models\Skills;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        if (($value == 'employee_image')) {
            $request->validate([
                'employee_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } else if (($value == 'resumelink')) {
            $request->validate([
                'resumelink' => 'required|mimes:pdf|max:2048',
            ]);
        }

        $file = ($value == 'employee_image') ? $request->file('employee_image') : $request->file('resumelink');
        $savedfile = $this->ImageService->saveImage($file, $value);

        // Return success response after saving employee image
        return response()->json(['message' => 'Employee image saved successfully', 'data' => $savedfile]);
    }

    /**
     * Store a newly created employee details.
     */
    public function saveEmployeeDetail(Request $request)
    {
        $savedImageFile = '';
        $savedResume = '';

        $rules = [
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
            'employee_image' => 'required',
            'isactive' => 'required',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 400);
        } else {
            if ($request->hasFile('employee_image')) {
                $savedImageFile = $this->saveEmployeeImage($request, 'employee_image');
            } else if ($request->hasFile('resumelink')) {
                $savedResume = $this->saveEmployeeImage($request, 'resumelink');
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
            $employee->resumelink = ($savedResume) ? $savedResume->getData()->data->id : null;
            $employee->employee_image = ($savedImageFile) ? $savedImageFile->getData()->data->id : null;
            $employee->isactive = $request->input('isactive');
            $employee->save();

            // Return success response after saving employee data
            return response()->json(['message' => 'Employee details saved successfully']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEmployeeDetail($id)
    {
        // Find the employee record by ID
        $employeeDetails = EmployeeDetails::find($id);

        return response()->json([['message' => 'Employee details fetched successfully'], 'employeeData' => $employeeDetails], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeDetail(Request $request, $employeeId)
    {
        try {
            // Find employee by employee ID column
            $employee = EmployeeDetails::where('employee_id', $employeeId)->first();

            $rules = [
                'employee_firstname' => 'required',
                'employee_middlename' => 'required',
                'employee_lastname' => 'required',
                'employee_code' => 'required',
                'employement_type' => 'required',
                'relevantexp' => 'required',
                'totalexp' => 'required',
                'location' => 'required',
                'startdate' => 'required|date',
                'enddate' => 'nullable|date',
                'resumelink' => 'required',
                'employee_image' => 'required',
                'isactive' => 'required',
            ];

            // Validate the request data
            $validator = Validator::make($request->all(), $rules);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 400);
            }

            // If employee not found, return error response
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Update employee details
            $employee->employee_firstname = $request->input('employee_firstname');
            $employee->employee_middlename = $request->input('employee_middlename');
            $employee->employee_lastname = $request->input('employee_lastname');
            $employee->employee_code = $request->input('employee_code');
            $employee->employement_type = $request->input('employement_type');
            $employee->relevantexp = $request->input('relevantexp');
            $employee->totalexp = $request->input('totalexp');
            $employee->location = $request->input('location');
            $employee->startdate = Carbon::parse($request->input('startdate'))->format('Y-m-d H:i:s');
            $employee->enddate = Carbon::parse($request->input('enddate'))->format('Y-m-d H:i:s');
            $employee->isactive = $request->input('isactive');

            // Check if a new image is uploaded
            if ($request->hasFile('employee_image')) {
                // Delete existing image (if any)
                if ($employee->employee_image) {
                    // Delete existing image file
                    Storage::delete('images/' . $employee->employee_image);
                }

                // Save new image
                $employee->employee_image = $this->saveEmployeeImage($request, 'employee_image')->getData()->data->id;
            } else if ($request->hasFile('resumelink')) {
                // Delete existing image (if any)
                if ($employee->resumelink) {
                    // Delete existing image file
                    Storage::delete('resumelink/' . $employee->resumelink);
                }

                // Save new resume
                $employee->resumelink = $this->saveEmployeeImage($request, 'resumelink')->getData()->data->id;
            }

            // // Save the updated employee details
            $employee->update();

            // Return success response
            return response()->json(['message' => 'Employee details updated successfully'], 200);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeEmployeeDetail($id)
    {
        // Find employee by employee ID column
        $employee = EmployeeDetails::where('employee_id', $id)->first();

        // If employee not found, return error response
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Delete associated image (if any)
        if ($employee->employee_image) {
            Storage::delete('images/' . $employee->employee_image);
        }

        // Delete associated resume (if any)
        if ($employee->resume) {
            // Assuming the resume is stored in a storage path
            Storage::delete('resumelink/' . $employee->resumelink);
        }

        // Delete employee record
        $employee->delete();

        // Return success response
        return response()->json(['message' => 'Employee details deleted successfully'], 200);
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
