@extends('admin.layout.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hazard Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">     
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Hazard Report</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                  </div>
              @endif
              <div class="card-header">
                
                <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-reports') }}" class="btn btn-block btn-warning">
                  <i class="fas fa-angle-double-left"></i>
                  Back</a>
              </div>
              

              <form name="hazardReportForm" id="hazardReportForm" method="POST" action="{{ url ('admin/hazard-update/'.$hazardReport['id'] ) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $hazardReport->id }}">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="nomor">Report No</label>
                      <input type="text" name="nomor" class="form-control" id="nomor" value="{{ $hazardReport->nomor }}" style="text-align : right; background-color: #656464;" disabled>               
                    </div>                                  
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="date_time">Date & Time</label>
                      <input name="date_time" class="form-control" id="date_time" value="{{ $hazardReport->created_at }}" style="text-align : right; background-color: #656464;" disabled>               
                    </div>                                  
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="project_code">Project</label>
                      <input name="project_code" class="form-control" id="project_code" value=" {{ Auth::guard('admin')->user()->project }} " style="text-align : right; background-color: #656464;" disabled>
                      <input type="hidden" name="project_code" id="project_code" value=" {{ Auth::guard('admin')->user()->project }} "> 
                      <input type="hidden" name="department_id" id="department_id"> 
                      <input type="hidden" name="position_id" id="position_id">             
                    </div>                                  
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="admin_id">Given To</label>
                        <select name="admin_id" id="admin_id" onchange="getDataAdmin(this)" class="form-control select2">
                          <option value="">--Select--</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}" data-department-id = "{{ $admin->department_id }} " data-position-id = "{{ $admin->position_id }}" {{ $hazardReport->admin_id == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                @endforeach
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                          <option value="">Select Category</option>
                                <option value="KTA" {{ $hazardReport->category == 'KTA' ? 'selected' : '' }}>KTA</option>
                                <option value="TTA" {{ $hazardReport->category == 'TTA' ? 'selected' : '' }}>TTA</option>
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="danger_type_id">Danger Type</label>
                        <select name="danger_type_id" id="danger_type_id" class="form-control select2">
                            <option value="">--Select Danger Type--</option>
                            @foreach ($danger_types as $danger_type)
                                <option value="{{ $danger_type->id }}" {{ $hazardReport->danger_type_id == $danger_type->id ? 'selected' : '' }}>{{ $danger_type->name }}</option>
                            @endforeach
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-sm-3">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Location</label>
                      <textarea class="form-control" name="location" id="location" rows="3" placeholder="Enter Location..." style="text-align: left">
                        {{ $hazardReport->location }}
                      </textarea>
                    </div>
                    
                  </div>
                  <div class="col-sm-3">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description..." style="text-align: left">
                        {{ $hazardReport->description }}
                      </textarea>
                    </div>
                    
                  </div>
                  <!-- Upload New Attachments -->
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Upload New Attachments</label>
                            <input type="file" name="file_upload[]" id="file" class="form-control" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt">
                            <small class="form-text text-muted">
                              <i class="fas fa-info-circle"></i> Maximum file size: 1MB per file. 
                              Supported formats: Images, PDF, Word, Excel, Text files.
                            </small>
                        </div>
                    </div>
                </div>
                   <!-- Display Existing Attachments -->
                  <div class="row mb-3">
                    <div class="col-sm-12">
                        <label>Existing Attachments</label>
                        @if($attachments && $attachments->count() > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($attachments as $attachment)
                                    <div class="attachment-item me-3 mb-3">
                                        @if(file_exists(public_path('document_upload/' . $attachment->filename)))
                                            <img src="{{ asset('document_upload/' . $attachment->filename) }}" alt="Attachment" style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <div style="width: 100px; height: 100px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                                                <span style="font-size: 12px; text-align: center;">File not found</span>
                                            </div>
                                        @endif
                                        <br>
                                        <small>{{ $attachment->filename }}</small><br>
                                        <input type="checkbox" name="delete_attachments[]" value="{{ $attachment->id }}"> Delete
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No attachments found for this hazard report.</p>
                            <!-- Debug info - remove this in production -->
                            <small class="text-info">Debug: Attachments count = {{ $attachments ? $attachments->count() : 'null' }}</small>
                        @endif
                    </div>
                </div>
                
                
                </div>             
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>     
      </div>  
      <!-- /.row -->
    </div>
 
   
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   <!-- /modal -->

@endsection

<script>
  function getDataAdmin(select) {
    var selectedOption = select.options[select.selectedIndex];

    // Ambil ID departemen dan posisi dari data attribute
    var departmentId = selectedOption.getAttribute('data-department-id');
    var positionId = selectedOption.getAttribute('data-position-id');

    // Set nilai elemen input berdasarkan ID
    document.getElementById('department_id').value = departmentId;
    document.getElementById('position_id').value = positionId;
  }
   
</script>

