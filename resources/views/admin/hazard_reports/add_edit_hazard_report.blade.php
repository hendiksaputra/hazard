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
              

              <form name="hazardReportForm" id="hazardReportForm" method="POST" action="{{ url ('admin/hazard-store' ) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="nomor">Report No</label>
                      <input type="text" name="nomor" class="form-control" id="nomor" value="{{ $nomor }}" style="text-align : right; background-color: #656464;" disabled>               
                    </div>                                  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="date_time">Date & Time</label>
                      <input name="date_time" class="form-control" id="date_time" value="{{ $date_time }}" style="text-align : right; background-color: #656464;" disabled>               
                    </div>                                  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="project_code">Project</label>
                      <input name="project_code" class="form-control" id="project_code" value=" {{ Auth::guard('admin')->user()->project }} " style="text-align : right; background-color: #656464;" disabled>
                      <input type="hidden" name="project_code" id="project_code" value=" {{ Auth::guard('admin')->user()->project }} "> 
                      <input type="hidden" name="department_id" id="department_id"> 
                      <input type="hidden" name="position_id" id="position_id">             
                    </div>                                  
                  </div>
                  {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="project_code">Project</label>
                        <select name="project_code" id="project_code" class="form-control select2">
                          <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project }}">{{ $project }}</option>
                                @endforeach
                        </select>               
                    </div>                                  
                  </div> --}}
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="admin_id">Given To</label>
                        <select name="admin_id" id="admin_id" onchange="getDataAdmin(this)" class="form-control select2">
                          <option value="">--Select--</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}" data-department-id = "{{ $admin->department_id }} " data-position-id = "{{ $admin->position_id }}">{{ $admin->name }}</option>
                                @endforeach
                        </select>               
                    </div>                                  
                  </div>
                  {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="department_id">Department</label>
                      <input name="department_id" class="form-control" id="department_id" value="">               
                    </div>                                  
                  </div> --}}
                  {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="position_id">Position</label>
                      <input name="position_id" class="form-control" id="position_id" value="">               
                    </div>                                  
                  </div> --}}
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                          <option value="">Select Category</option>
                                <option value="KTA">KTA</option>
                                <option value="TTA">TTA</option>
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="danger_type_id">Danger Type</label>
                        <select name="danger_type_id" id="danger_type_id" class="form-control select2">
                          <option value="">Select Danger Type</option>
                                @foreach ($danger_types as $danger_type)
                                    <option value="{{ $danger_type->id }}">{{ $danger_type->name }}</option>
                                @endforeach
                        </select>               
                    </div>                                  
                  </div>
                  <div class="col-sm-4">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Description..."></textarea>
                    </div>
                    
                  </div>
                  <div class="col-sm-4">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Location</label>
                      <textarea class="form-control" name="location" id="location" rows="3" placeholder="Enter Location..."></textarea>
                    </div>
                    
                  </div>
                  <div class="col-sm-4">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Attachment</label>
                      <input type="file" name="file_upload[]" id="file" class="form-control" multiple>
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

