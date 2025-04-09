@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hazard Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hazard Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Hazard Report Detail</h3>
                  
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-closed-index') }}" 
                    class="btn btn-block btn-warning"><i class="fas fa-angle-double-left"></i> Back</a>
                  
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Report No</dt>
                        <dd class="col-sm-8">: <b>{{ $hazard->nomor }}</b></dd>
                        <dt class="col-sm-4">Date & Time</dt>
                        <dd class="col-sm-8">: {{ $hazard->created_at->addHours(8)->format('d M Y - H:i:s') }} </dd>
                        <dt class="col-sm-4">Project</dt>
                        <dd class="col-sm-8">: {{ $hazard->project_code }}</dd>
                        <dt class="col-sm-4">To Department</dt>
                        <dd class="col-sm-8">: {{ $hazard->department_name }}</dd>
                        <dt class="col-sm-4">Category</dt>
                        <dd class="col-sm-8">: {{ $hazard->category }}</dd>
                        <dt class="col-sm-4">Danger Type</dt>
                        <dd class="col-sm-8">: {{ $hazard->danger_type_name }}</dd>
                         
                        </dd>
                        <dt class="col-sm-4">Created by | Department</dt>
                        <dd class="col-sm-8">: {{ $hazard->created_by }} | {{ $hazard->department_name }} </dd>
                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">: {{ $hazard->description }}</dd>
                      </dl>
                </div>
                <div class="card-header">
                    <h3 class="card-title"> Hazard Report Attachment</h3>
                   
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>File Name</th>
                          <th>Uploaded By</th>
                          <th>Uploaded At</th>
                          <th class="text-center">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($attachments as $attachment)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attachment->filename }}</td>
                            <td>{{ $attachment->uploaded_by_name }}</td>
                            <td>{{ $attachment->created_at->addHours(8)->format('d M Y - H:i:s') }}</td>
                            <td class="text-center">
                              <a href="{{ asset('document_upload') . '/' . $attachment->filename }}" class='btn btn-xs btn-info' target=_blank>view</a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="card-body">
                    <table id="response-table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Response At</th>
                          <th>Response By</th>
                          <th>Comment</th>
                          <th>attachment</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($responses as $response)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $response->created_at->addHours(8)->format('d M Y - H:i:s') }}</td>
                            <td>{{ $response->created_by_name }}</td>
                            <td>{{ $response->comment }}</td>
                            <td class="text-center">
                                  <a href="{{ asset('document_upload') . '/' . $response->filename }}" class='btn btn-xs btn-info' target=_blank>view</a> 
                          </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection

 
