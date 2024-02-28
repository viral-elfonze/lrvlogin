<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
}
