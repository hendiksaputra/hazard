<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminsRole;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'departments');
        $departments = Department::get();

         // Set admin/Subadmins permission permission
         $departmentModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
                                    id,'module'=>'departments'])->count();
         $departmentModule = array();
         if(Auth::guard('admin')->user()->type=="admin"){
             $departmentModule['view_access'] = 1;
             $departmentModule['edit_access'] = 1;
             $departmentModule['full_access'] = 1;
         }else if($departmentModuleCount==0){
             $message = "This feature is restricted for you!";
             return redirect('admin/dashboard')->with('error_message', $message);
         }else{
             $departmentModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
             id,'module'=>'departments'])->first()->toArray();
         }

        return view('admin.departments.index')->with(compact('departments', 'departmentModule'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id=null)
    {
        Session::put('page', 'departments');

        if($id==""){
            $title = "Add Department Name";
            $department = new Department;
            $message = "Department name added successfully";

        }else{
            $title = "Edit Department Name";
            $department = Department::find($id);
            $message = "Department name updated successfully";
            
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'department_name' => 'required',
            ]; 

            $customMessages = [
                'department_name.required' => 'Department name is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $department->department_name = $data['department_name'];
            $department->save();
            
            return redirect('admin/departments')->with('success_message', $message);

            }

        return view('admin.departments.add_edit_department')->with(compact('title', 'department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Department::where('id',$id)->delete();
        return redirect('admin/departments')->with('success_message', 'Department name deleted successfully');
    }
}
