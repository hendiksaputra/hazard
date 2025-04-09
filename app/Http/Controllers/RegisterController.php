<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Position;
use App\Models\Register;

use App\Models\Department;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ['000H', '001H', '017C', '021C', '022C', '023C', 'APS'];
        $departments = Department::orderBy('department_name', 'asc')->get();
        $positions = Position::orderBy('position_name', 'asc')->get();

        return view('admin.register')->with(compact('projects', 'departments', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:admins',
            'email' => 'required|unique:admins',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
            'project' => 'required',
        ]);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->type = 'subadmin';
        $admin->department_id = $request->department_id;
        $admin->position_id = $request->position_id;
        $admin->project = $request->project;
        $admin->status = 1;
        $admin->save();

        return redirect()->back()->with('success_message', 'Subadmin added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Register $register)
    {
        //
    }
}
