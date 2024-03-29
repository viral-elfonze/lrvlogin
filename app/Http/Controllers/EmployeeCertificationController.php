<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeCertification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeCertificationController extends Controller
{
    protected $ImageService;

    public function __construct(ImageService $ImageService)
    {
        $this->middleware('cors');
        $this->ImageService = $ImageService;
    }

    /**
     * Store a newly created employee image or employee resume.
     */
    public function saveCertificationImage(Request $request, String $value)
    {
        $file = $request->file('certification_image');
        $savedFile = $this->ImageService->saveImage($file, $value);

        // Return success response after saving employee image
        return response()->json(['status' => 'success', 'message' => 'Employee certificate saved successfully', 'data' => $savedFile]);
    }

    /**
     * Store a newly created employee certification.
     */
    public function saveEmployeeCertification(Request $request)
    {
        try {
            $savedImageFile = '';

            $rules = [
                'employee_skill_matrix_id' => 'required|exists:employee_skill_matrix,id',
                'name' => 'required',
                'number' => 'nullable',
                'description' => 'nullable',
                'issue_date' => 'nullable',
                'expiry_date' => 'nullable'
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

            if ($request->hasFile('certification_image')) {
                $savedImageFile = $this->saveCertificationImage($request, 'certification_image');
            }

            $employeeCertificate = new EmployeeCertification();
            $employeeCertificate->employee_skill_matrix_id = $request->input('employee_skill_matrix_id');
            $employeeCertificate->name = $request->input('name');
            $employeeCertificate->number = $request->input('number');
            $employeeCertificate->description = $request->input('description');
            $employeeCertificate->issue_date = $request->input('issue_date');
            $employeeCertificate->expiry_date = $request->input('expiry_date');
            $employeeCertificate->certification_image = ($savedImageFile) ? $savedImageFile->getData()->data->id : null;
            $employeeCertificate->save();

            // Return success response after saving employee certification data
            return response()->json(['status' => 'success', 'message' => 'Employee certification data saved successfully']);
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
    public function updateEmployeeCertification(Request $request, $id)
    {
        try {
            // Find employee certificate by employee certificate ID column
            $employeeCertificate = EmployeeCertification::where('id', $id)->first();

            $rules = [
                'employee_skill_matrix_id' => 'required|exists:employee_skill_matrix,id',
                'name' => 'required',
                'number' => 'nullable',
                'description' => 'nullable',
                'issue_date' => 'nullable',
                'expiry_date' => 'nullable'
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

            // If employee certificate not found, return error response
            if (!$employeeCertificate) {
                return response()->json(['status' => 'error', 'message' => 'Employee certificate not found', 'data' => []]);
            }

            // Update employee details
            $employeeCertificate->employee_skill_matrix_id = $request->input('employee_skill_matrix_id');
            $employeeCertificate->name = $request->input('name');
            $employeeCertificate->number = $request->input('number');
            $employeeCertificate->description = $request->input('description');
            $employeeCertificate->issue_date = $request->input('issue_date');
            $employeeCertificate->expiry_date = $request->input('expiry_date');

            // Check if a new image is uploaded
            if ($request->hasFile('certification_image')) {
                // Delete existing certificate (if any)
                if ($employeeCertificate->certification_image) {
                    // Delete existing certificate file
                    Storage::delete('certification_image/' . $employeeCertificate->certification_image);
                }

                $employeeCertificate->certification_image = $this->saveCertificationImage($request, 'certification_image')->getData()->data->id;
            }

            // Save the updated employee details
            $employeeCertificate->update();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Employee certification details updated successfully']);
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
    public function removeCertification($id)
    {
        try {
            // Find employee certificate by employee certificate id column
            $employee = EmployeeCertification::where('id', $id)->first();

            // If employee not found, return error response
            if (!$employee) {
                return response()->json(['status' => 'error', 'message' => 'Employee certificates not found', 'data' => []]);
            }

            // Delete associated image (if any)
            if ($employee->certification_image) {
                Storage::delete('certification_image/' . $employee->certification_image);
            }

            // Delete employee certificates
            $employee->delete();

            // Return success response
            return response()->json(['status' => 'success', 'message' => 'Employee certificate deleted successfully']);
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
    public function showEmployeeCertificates($certificate_id)
    {
        try {
            // Find the employee record by ID
            $employeeCertificates = EmployeeCertification::with(['employeeSkillMatrix', 'employeeSkillMatrix.skills', 'employeeSkillMatrix.employeeDetails'])->where('id', $certificate_id)->get();

            if (!$employeeCertificates) {
                return response()->json(['status' => 'error', 'message' => 'Employee certificates not found', 'data' => []]);
            } else {
                // Decode the JSON data
                $data = json_decode(json_encode($employeeCertificates), true);
                if (isset($data) && !empty($data)) {
                    if (isset($data[0]['certification_image'])) {
                        $path = $this->ImageService->getImagePath($data[0]['certification_image']);
                        $data[0]['certification_image'] = $path;
                    }
                }

                return response()->json([['status' => 'success', 'message' => 'Employee certificates fetched successfully'], 'data' => $data,'employeeCertificates'=>$employeeCertificates]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified employee certificate by id.
     */
    public function showEmployeeCertificateById($employee_id)
    {
        try {
            // Find the employee records with related data
            $employeeCertificates = EmployeeCertification::with(['employeeSkillMatrix.skills', 'employeeSkillMatrix.employeeDetails'])
                ->whereHas('employeeSkillMatrix', function ($query) use ($employee_id) {
                    $query->where('employee_id', $employee_id);
                })->get();

            if (!$employeeCertificates) {
                return response()->json(['status' => 'error', 'message' => 'Employee certificates not found', 'data' => []]);
            } else {
                // Decode the JSON data
                $data = json_decode($employeeCertificates, true);

                if (isset($data) && !empty($data)) {
                    if (isset($data[0]['certification_image'])) {
                        $path = $this->ImageService->getImagePath($data[0]['certification_image']);
                        $data[0]['certification_image'] = $path;
                    }
                }

                return response()->json([['status' => 'success', 'message' => 'Employee certificates fetched successfully'], 'data' => $data]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
