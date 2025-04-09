<?php

namespace App\Http\Controllers\Admin;

use App\Models\Position;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page', 'positions');
        $positions = Position::all();
         // Set admin/Subadmins permission permission
         $positionsModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
                                id,'module'=>'positions'])->count(); 
         $positionsModule = array();
         if(Auth::guard('admin')->user()->type=="admin"){
             $positionsModule['view_access'] = 1;
             $positionsModule['edit_access'] = 1;
             $positionsModule['full_access'] = 1;
         }else if($positionsModuleCount==0){
             $message = "This feature is restricted for you!";
             return redirect('admin/dashboard')->with('error_message', $message);
         }else{
             $positionsModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->
             id,'module'=>'positions'])->first()->toArray();
         }

        return view('admin.positions.index')->with(compact('positions', 'positionsModule'));
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
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id=null)
    {
        Session::put('page', 'positions');
        

        if($id==""){
            $title = "Add Position Name";
            $position = new Position;
            $message = "Position name added successfully";

        }else{
            $title = "Edit Position Name";
            $position = Position::find($id);
            $message = "Position name updated successfully";
            
        }

        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // position name tidak boleh kosog dan tidak boleh ada yang sama
            $rules = [
                'position_name' => 'required|unique:positions,position_name,'.$position->id,

            ]; 

            $customMessages = [
                'position_name.required' => 'Position name is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $position->position_name = $data['position_name'];
            $position->save();
            
            return redirect('admin/positions')->with('success_message', $message);

            }

        return view('admin.positions.add_edit_position')->with(compact('title', 'position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Position::where('id',$id)->delete();
        return redirect('admin/positions')->with('success_message', 'Position name deleted successfully');
    }
}
