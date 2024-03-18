<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDetails;
use App\Models\ImageMaster;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $imageService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ImageService $imageService)
    {
        // $this->middleware('auth');
        $this->imageService = $imageService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function test(Request $request){
        dd("tes");
    }
    public function userdetails()
    {

        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
        }
        $data['user'] = $user;
        if ($user->roles->isNotEmpty()) {
            foreach ($user->roles as $role) {
                $user['roles'] = $role->rolename; // Role's name
            }
        }
        //add employee
        if ($user) {
            $employee = EmployeeDetails::where('user_id', $user->id)->first();
            $data = json_decode($employee, true);

            if (isset($data) && !empty($data)) {
                if (isset($data['employee_image'])) {
                    $path = $this->imageService->getImagePath($data['employee_image']);
                    $data['employee_image'] = $path;
                }
                if (isset($data['resumelink'])) {
                    $path = $this->imageService->getImagePath($data['resumelink']);
                    $data['resumelink'] = $path;
                }
            }
            $user['employee'] = $data;
        }

        $response = [
            'status' => 'success',
            'message' => 'User details.',
            'data' => $user,
        ];

        return response()->json($response, 200);


        //     return "userdetails";
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], 200);
        // dd($request->user()->token());
        // return view('home');
    }

    public function list(Request $request)
    {

        $query = User::query();

        // Apply sorting
        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_order', 'asc'));
        }

        // Apply filtering
        if ($request->has('filter')) {
            $query->where('name', 'like', '%' . $request->input('filter') . '%');
        }

        // Paginate the results
        $page = $request->input('page', 1); // Default page number is 1
        $items = $query->paginate($request->input('per_page', 10), ['*'], 'page', $page);

        return response()->json($items);
    }

    //image upload example
    public function uploadImage(Request $request)
    {

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            // Call the saveImage method of the ImageService
            $imageObj = $this->imageService->saveImage($file, $request->input('module'));
            // 3
            // Optionally, save the filename to the database or perform any other operations

            return 'Image uploaded successfully.';
        } else {
            dd("2");
        }

        return 'No image uploaded.';
    }

    public function getImage(Request $request)
    {


        if ($request->has('image_id')) {

            $imageDetail = ImageMaster::where('id', $request->input('image_id'))->first();

            if ($imageDetail) {
                return env('IMAGE_PATH') . env('IMAGE_UPLOAD') . $imageDetail->path . "/" . $imageDetail->filename;
            }
        } else {
            return 'image not found';
        }
    }
}
