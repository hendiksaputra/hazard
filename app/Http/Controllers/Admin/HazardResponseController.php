<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HazardResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HazardResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function get_data($hazard_report_id)
    {
        $hazard_responses = HazardResponse::where('hazard_report_id', $hazard_report_id)->get();

        return $hazard_responses;
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
    public function store($data)
    {
        $data->validate([
            'hazard_report_id' => 'required',
            'comment' => 'required',
        ]);

        if ($data->hasFile('file_upload')) {
            $file = $data->file('file_upload');
            $filename = rand() . '_' . $file->getClientOriginalName();
            $file->move(public_path('document_upload'), $filename);
        } else {
            $filename = null;
        }

        $hazard_response = new HazardResponse();
        $hazard_response->hazard_report_id = $data->hazard_report_id;
        $hazard_response->comment_by = Auth::guard('admin')->user()->id;
        $hazard_response->comment = $data->comment;
        $hazard_response->filename = $filename;
        $hazard_response->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(HazardResponse $hazardResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HazardResponse $hazardResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HazardResponse $hazardResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $hazard_response = HazardResponse::findOrFail($id);
        $hazard_response->delete();

        return redirect()->back()->with('success_message', 'Attachment deleted successfully');

    }
}
