<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ReportAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'file_upload' => 'required|file|max:1024', // Max 1MB (1024 KB)
        ]);

        $file = $data->file('file_upload');
        
        // Additional file size check (1MB = 1 * 1024 * 1024 bytes)
        if ($file->getSize() > 1 * 1024 * 1024) {
            return redirect()->back()->withErrors(['file_upload' => 'File size must not exceed 1MB.']);
        }

        $filename = rand() . '_' . $file->getClientOriginalName();
        $file->move(public_path('document_upload'), $filename);

        $attachment = new ReportAttachment();
        $attachment->hazard_report_id = $data->hazard_report_id;
        $attachment->filename = $filename;
        $attachment->uploaded_by = Auth::guard('admin')->user()->id;
        $attachment->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(ReportAttachment $reportAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportAttachment $reportAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReportAttachment $reportAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $report_attachment = ReportAttachment::findOrFail($id);
        $report_attachment->delete();

        return redirect()->back()->with('success_message', 'Attachment deleted successfully');

    }
}
