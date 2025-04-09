<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminsRole;
use App\Models\DangerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DangerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'danger-types');
        $dangerTypes = DangerType::get();

        // Set admin/Subadmins permission permission
        $dangerTypeModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
                                       id,'module'=>'danger-types'])->count();
        $dangerTypeModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $dangerTypeModule['view_access'] = 1;
            $dangerTypeModule['edit_access'] = 1;
            $dangerTypeModule['full_access'] = 1;
        }else if($dangerTypeModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message', $message);
        }else{
            $dangerTypeModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
            id,'module'=>'danger-types'])->first()->toArray();
        }

        return view('admin.danger-types.index')->with(compact('dangerTypes', 'dangerTypeModule'));
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
    public function show(DangerType $dangerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id=null)
    {
        Session::put('page', 'danger-types');

        if($id==""){
            $title = "Add Danger Type";
            $dangerType = new DangerType;
            $message = "Danger Type added successfully";

        }else{
            $title = "Edit Danger Type";
            $dangerType = DangerType::find($id);
            $message = "Danger Type updated successfully";
            
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'name' => 'required',
            ]; 

            $customMessages = [
                'name.required' => 'Danger type name is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $dangerType->name = $data['name'];
            $dangerType->save();
            
            return redirect('admin/danger-types')->with('success_message', $message);

            }

        return view('admin.danger-types.add_edit_danger_type')->with(compact('title', 'dangerType'));
}

    /**
     * Update the specified resource in storage.
     */
    
    /**
     * Remove the specified resource from storage.
     * 
     * 
     * 
     */

     public function destroy($id)
    {
        DangerType::where('id',$id)->delete();
        return redirect('admin/danger-types')->with('success_message', 'Danger Type deleted successfully');
    }

}
