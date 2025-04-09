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
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  </div>
              @endif
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Hazard Report Detail</h3>              
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-reports') }}" 
                    class="btn btn-block btn-warning"><i class="fas fa-angle-double-left"></i> Back</a>                 
                </div>
                <div class="card-header">
                      <form action="{{ url ('admin/hazard-report-closed/'.$hazard->id )}}" method="POST" class="d-inline-block">
                        @csrf
                        <button type="submit" style="max-width: 150px; float:right; display:inline-block;" class="btn btn-block btn-primary btn-sm" onclick="return confirm('Are you sure to close this record?')"><i class="fas fa-check"></i> Close Report</button>
                      </form>                  
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
                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">: 
                            @if ($hazard->status == 'pending')
                                <span class="badge badge-danger">Pending</span>
                            @else
                                <span class="badge badge-success">Closed</span>
                            @endif
                        
                        </dd>

                      </dl>
                </div>
                <div class="card-header">
                    <h3 class="card-title"> Hazard Report Attachment</h3>
                        <button data-toggle="modal" data-target="#modal-attachment" class="btn btn-sm btn-default float-right"> Add Attachment</button>
                   
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
                              <a href="{{ url( 'admin/delete-report-attachment/' . $attachment->id ) }}" onclick="return confirm('Are you sure to delete this record?')" class='btn btn-xs btn-danger'>delete</a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <div class="card-header">
                    <h3 class="card-title"> Hazard Responses</h3>
                    <button data-toggle="modal" data-target="#modal-response" class="btn btn-sm btn-default float-right"> Add Response</button>
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
                            <td>{{ $response->created_by_name}}</td>
                            <td>{{ $response->comment }}</td>
                            <td class="text-center">
  
                              <a href="{{ asset('document_upload') . '/' . $response->filename }}" class='btn btn-xs btn-info' target=_blank>view</a> 
                              <a href="{{ url( 'admin/delete-response/' . $response->id ) }}" onclick="return confirm('Are you sure to delete this record?')" class='btn btn-xs btn-danger'>delete</a>

                            </td>
                          </tr>
                        @endforeach
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
{{-- modal-attachment --}}
<div class="modal fade" id="modal-attachment">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload File</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('admin/hazard-rpt-store-attachment') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="hazard_report_id" value="{{ $hazard->id }}">
            <div class="form-group">
              <label for="file_upload">Upload Attachment</label>
              <input type="file" name="file_upload" id="file_upload" class="form-control">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Submit</button>
          </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal-attachment -->

  {{-- modal-response --}}
  <div class="modal fade" id="modal-response">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Response</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('admin/hazard-rpt-store-response') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="hazard_report_id" value="{{ $hazard->id }}">
            <div class="form-group">
              <label for="comment">Comment</label>
              <textarea name="comment" id="comment" class="form-control" cols="30" rows="3">{{ old('comment') }}</textarea>
            </div>
            <div class="form-group">
              <label for="file_upload">Upload Attachment <small>(optional)</small></label>
              <input type="file" name="file_upload" id="file_upload" class="form-control">
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Submit</button>
          </div>
        </form>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal-response -->

@endsection

 
