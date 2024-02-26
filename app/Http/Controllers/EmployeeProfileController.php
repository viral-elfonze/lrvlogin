<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeProfile;

class EmployeeProfileController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeProfile::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'emp_id' => 'required|unique:employee_profiles',
            'emp_code' => 'required|unique:employee_profiles',
            'emp_type' => 'required',
            'relevent_exp' => 'required',
            'current_location' => 'required',
            'emp_start_date' => 'required|date',
            'emp_end_date' => 'nullable|date',
            'attached_resume' => 'nullable',
        ]);

        return EmployeeProfile::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeProfile $employeeProfile)
    {
        return $employeeProfile;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeProfile $employeeProfile)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'emp_id' => 'required|unique:employee_profiles,emp_id,' . $employeeProfile->id,
            'emp_code' => 'required|unique:employee_profiles,emp_code,' . $employeeProfile->id,
            'emp_type' => 'required',
            'relevent_exp' => 'required',
            'current_location' => 'required',
            'emp_start_date' => 'required|date',
            'emp_end_date' => 'nullable|date',
            'attached_resume' => 'nullable',
        ]);

        $employeeProfile->update($request->all());

        return $employeeProfile;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeProfile $employeeProfile)
    {
        $employeeProfile->delete();

        return response()->json(null, 204);
    }
}
