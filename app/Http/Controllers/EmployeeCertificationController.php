<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Models\EmployeeSkillMatrix;
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
    public function saveEmployeeImage(Request $request, String $value)
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
                'employee_id' => 'required',
                'name' => 'required|exists:skills,skill_id',
                'number' => 'required|integer|min:0',
                'description' => 'required',
                'issue_date' => 'required',
                'expiry_date' => 'required'
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
                $savedImageFile = $this->saveEmployeeImage($request, 'certification_image');
            }

            $employeeCertificate = new EmployeeSkillMatrix();
            $employeeCertificate->employee_id = $request->input('employee_id');
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
}
