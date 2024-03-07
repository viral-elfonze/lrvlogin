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
        $this->middleware('cors');
        $this->ImageService = $ImageService;
    }
    // public function __construct(ImageService $imageService)
    // {
    //     $this->middleware('auth');
    //     $this->imageService = $imageService;
    // }


    /**
     * Display a listing of the resource.
     */
    public function getEmployeeDetails()
    {
        try {
            $employeesData = EmployeeDetails::all();

            //If employee data not found
            if (!$employeesData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employees data not found.',
                    'data' => $employeesData,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Employees data retrieved successfully.',
                'data' => $employeesData
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display a listing of the skills.
     */
    public function getEmployeeSkills()
    {
        try {
            $skillsData = Skills::all();

            if (!$skillsData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee skills data not found.',
                    'data' => $skillsData,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Employee skills data retrieved successfully.',
                'data' => $skillsData,
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
    public function saveEmployeeImage(Request $request, String $value)
    {
        $file = ($value == 'employee_image') ? $request->file('employee_image') : $request->file('resumelink');
        $savedfile = $this->ImageService->saveImage($file, $value);

        // Return success response after saving employee image
        return response()->json(['status' => 'success', 'message' => 'Employee image saved successfully', 'data' => $savedfile]);
    }

    /**
     * Store a newly created employee details.
     */
    public function saveEmployeeDetail(Request $request)
    {
        try {
            $savedImageFile = '';
            $savedResume = '';

            $rules = [
                'employee_firstname' => 'required',
                'employee_middlename' => 'nullable',
                'employee_lastname' => 'required',
                'employee_code' => 'required|unique:employee_details',
                'employement_type' => 'required',
                'relevantexp' => 'required|integer|min:0',
                'totalexp' => 'required|integer|min:0',
                'location' => 'required',
                'startdate' => 'required',
                'enddate' => 'nullable',
                'resumelink' => 'required|mimes:pdf|max:2048',
                'employee_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'isactive' => 'required|boolean',
            ];

            // Validate the request data
            $validator = Validator::make($request->all(), $rules);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'data' => $validator->errors(),
                ]);
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
                return response()->json(['status' => 'success', 'message' => 'Employee details saved successfully']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showEmployeeDetail($id)
    {
        try {
            // Find the employee record by ID
            $employeeDetails = EmployeeDetails::with('imageMaster')->where('user_id', $id)->get();

            if (!$employeeDetails) {
                return response()->json(['status' => 'error', 'message' => 'Employee details not found']);
            }

            // Decode the JSON data
            $data = json_decode($employeeDetails, true);

            // Check if "data" key exists and is not empty
            if (isset($data['data']) && !empty($data['data'])) {
                // Get the first employee's image value
                $employeeImageValue = $data['data'][0]['employee_image'];
                $data['data'][0]['employee_image'] = app(PostController::class)->getImage($employeeDetails['employee_image']);

                // Print or use the value as needed
                echo "Employee Image Value: " . $employeeImageValue;
            } else {
                // Handle the case where "data" key is missing or empty
                echo "No employee data found";
            }

            return response()->json([['status' => 'success', 'message' => 'Employee details fetched successfully'], 'data' => $employeeDetails]);
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
    public function updateEmployeeDetail(Request $request, $employeeId)
    {
        try {
            // Find employee by employee ID column
            $employee = EmployeeDetails::where('employee_id', $employeeId)->first();

            $rules = [
                'employee_firstname' => 'required',
                'employee_middlename' => 'nullable',
                'employee_lastname' => 'required',
                'employee_code' => 'required',
                'employement_type' => 'required',
                'relevantexp' => 'required|integer|min:0',
                'totalexp' => 'required|integer|min:0',
                'location' => 'required',
                'startdate' => 'required',
                'enddate' => 'nullable',
                'resumelink' => 'required|mimes:pdf|max:2048',
                'employee_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'isactive' => 'required|boolean',
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

            // If employee not found, return error response
            if (!$employee) {
                return response()->json(['status' => 'error', 'message' => 'Employee not found']);
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
            $employee->startdate = $request->input('startdate');
            $employee->enddate = $request->input('enddate');
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
            return response()->json(['status' => 'error', 'message' => 'Employee details updated successfully']);
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
    public function removeEmployeeDetail($id)
    {
        try {
            // Find employee by employee ID column
            $employee = EmployeeDetails::where('employee_id', $id)->first();

            // If employee not found, return error response
            if (!$employee) {
                return response()->json(['status' => 'error', 'message' => 'Employee not found']);
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
            return response()->json(['status' => 'success', 'message' => 'Employee details deleted successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Verify employee id is exists or not.
     */
    public function verifyemployee_id($employee_id)
    {
        try {
            // Implement logic to check if the employee ID exists in the database
            $employeeExists = EmployeeDetails::where('employee_id', $employee_id)->exists();

            // Return response based on the result
            return response()->json(['status' => 'success', 'employee_exists' => $employeeExists]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Verify employee code is exists or not.
     */
    public function verifyemployee_code($employee_code)
    {
        try {
            // Implement logic to check if the employee ID exists in the database
            $employeeExists = EmployeeDetails::where('employee_code', $employee_code)->exists();

            // Return response based on the result
            return response()->json(['status' => 'success', 'employee_code_exists' => $employeeExists]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display a listing of the all locations.
     */
    public function getLocations()
    {
        try {
            $locations = Locations::all();

            // If locations not found, return error response
            if (!$locations) {
                return response()->json(['status' => 'error', 'message' => 'Locations not found']);
            }

            // Return JSON response with a message
            return response()->json([
                'status' => 'success',
                'message' => 'Locations retrieved successfully.',
                'data' => $locations,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
