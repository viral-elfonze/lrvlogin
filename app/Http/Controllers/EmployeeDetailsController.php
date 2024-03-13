<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Skills;
use App\Models\Locations;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeDetails;
use App\Models\EmployeeSkillMatrix;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeDetailsController extends Controller
{
    protected $ImageService;

    public function __construct(ImageService $ImageService)
    {
        $this->middleware('cors');
        $this->ImageService = $ImageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function getEmployeeDetails(Request $request)
    {
        try {
            // dump('Java', 'PHP');
            // dd($request->input('skills'));
            $employeesData = EmployeeDetails::where('deleted_at', null)
            ->with('userObj')
            // ->whereHas('employeeSkillsId')
            ->with(['employeeSkillsId' => function ($query) use($request) {
                if($request->has('skills')){
                    $skills = explode(',',$request->input('skills'));
                    $query->whereIn('skill', $skills);
                }
            }]);
            if($request->has('skills')){
                $employeesData->whereHas('employeeSkillsId');
            }
            $temp =$employeesData->get();

            // if($request->has('full_name')){
            //     // $employeesData->where('FullName','like', '%' . $request->input('full_name') . '%');
            //     $employeesData->whereRaw("CONCAT(employee_firstname, ' ', employee_firstname, ' ', employee_firstname) LIKE '%".$request->has('full_name')."%'");
            // }


            // $employeesData = EmployeeDetails::where('deleted_at', null)
            //     ->with('employeeSkillsId')
            //     ->whereHas('employeeSkillsId', function ($query) {
            //         $query->whereIn('skill_id', function ($subQuery) {
            //             $subQuery->select('skill_id')
            //                 ->from('skills')
            //                 ->whereIn('skill', ['Java', 'PHP']);
            //         });
            //     })
            //     ->with(['employeeSkillsId' => function ($query) {
            //         $query->whereIn('skill', ['Java', 'PHP']); // Example condition: amount greater than 1000
            //     }])
            //     ->with('userObj')
                // ->where('employee_code','ET1208')
                // ->where('employee_skills_id.employee_id', '=', 1)
                // ->join('employee_skill_matrix', 'employee_skill_matrix.employee_id', '=', 'employee_details.employee_id')
                // ->groupBy('employee_skill_matrix.employee_id')
                // ->select('employee_details.*','')
                // if ($request->has('sort_by')) {
                //     $employeesData->orderBy($request->input('sort_by'), $request->input('sort_order', 'asc'));
                // }
                // $page = $request->input('page', 1); // Default page number is 1
                // $items = $employeesData->paginate($request->input('per_page', 10), ['*'], 'page', $page);

            // $employeesSkills = EmployeeSkillMatrix::join('employee_details', 'employee_skill_matrix.employee_id', '=', 'employee_details.employee_id')
            // ->join('skills', 'employee_skill_matrix.skill_id', '=', 'skills.skill_id')

            //If employee data not found
            if (!$temp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employees data not found.',
                    'data' => $temp,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Employees data retrieved successfully.',
                'data' => $temp
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
        $saved_file = $this->ImageService->saveImage($file, $value);

        // Return success response after saving employee image
        return response()->json(['status' => 'success', 'message' => 'Employee image saved successfully', 'data' => $saved_file]);
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
                'employee_code' => [
                    'required',
                    Rule::unique('employee_details')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    }),
                ],
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
                }

                if ($request->hasFile('resumelink')) {
                    $savedResume = $this->saveEmployeeImage($request, 'resumelink');
                }

                $employee = new EmployeeDetails();
                $employee->user_id = auth()->user()->id;
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
            $employeeDetails = EmployeeDetails::where(['employee_id' => $id, 'deleted_at' => null])->get();

            if (!$employeeDetails) {
                return response()->json(['status' => 'error', 'message' => 'Employee details not found', 'data' => []]);
            } else {
                // Decode the JSON data
                $data = json_decode($employeeDetails, true);

                if (isset($data) && !empty($data)) {
                    if (isset($data[0]['employee_image'])) {
                        $path = $this->ImageService->getImagePath($data[0]['employee_image']);
                        $data[0]['employee_image'] = $path;
                    }
                    if (isset($data[0]['resumelink'])) {
                        $path = $this->ImageService->getImagePath($data[0]['resumelink']);
                        $data[0]['resumelink'] = $path;
                    }
                }

                return response()->json([['status' => 'success', 'message' => 'Employee details fetched successfully'], 'data' => $data]);
            }
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
            $employee = EmployeeDetails::where(['employee_id' => $employeeId, 'deleted_at' => null])->first();

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
                'resumelink' => 'required',
                'employee_image' => 'required',
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
                return response()->json(['status' => 'error', 'message' => 'Employee not found', 'data' => []]);
            }

            // Update employee details
            $employee->user_id = auth()->user()->id;
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
                return response()->json(['status' => 'error', 'message' => 'Employee not found', 'data' => []]);
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
                return response()->json(['status' => 'error', 'message' => 'Locations not found', 'data' => []]);
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

    /**
     * Display a listing of the employee data with filter.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeDetailsWithFilter(Request $request)
    {
        // Start with a query to retrieve all employees kill matrix
        $employeesSkills = EmployeeSkillMatrix::join('employee_details', 'employee_skill_matrix.employee_id', '=', 'employee_details.employee_id')
            ->join('skills', 'employee_skill_matrix.skill_id', '=', 'skills.skill_id')
            ->join('employee_certifications', 'employee_certifications.employee_skill_matrix_id', '=', 'employee_skill_matrix.id')
            ->select(
                'skills.skill',
                'employee_details.employee_id',
                'employee_details.employee_firstname',
                'employee_details.employee_lastname',
                'employee_details.resumelink',
                'employee_details.relevantexp',
                'employee_details.totalexp',
                'employee_certifications.*'
            );

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
        $employeesData = [];
        $i = 0;

        // Decode the JSON data
        $data = json_decode($employees, true);

        if (isset($data) && !empty($data)) {
            foreach ($data as $employee) {
                if (isset($employee['resumelink'])) {
                    $path = $this->ImageService->getImagePath($employee['resumelink']);
                    $employee['resumelink'] = $path;
                }

                if (isset($employee['certification_image'])) {
                    $path = $this->ImageService->getImagePath($employee['certification_image']);
                    $employee['certification_image'] = $path;
                }

                $employeesData[$i] = $employee;
                $i++;
            }
        }

        // Return JSON response with a message
        return response()->json([
            'status' => 'success',
            'message' => 'All Filtered Employee data retrieved successfully.',
            'data' => $employeesData,
        ]);
    }
}
