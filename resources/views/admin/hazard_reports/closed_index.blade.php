@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Hazard Reports</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Hazard Reports</li>
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
                    <a style="max-width: 150px; float:right; display:inline-block;" href="{{ url('admin/hazard-reports') }}">Pending Reports</a>      
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="hazard-rpt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nomor</th>
                            <th>Project</th>
                            <th>To Dept</th>
                            <th>Created at</th>
                            <th>Description</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hazards as $page)
                          <tr>
                            <td>{{ $page['id'] }}</td>
                            <td>{{ $page['nomor'] }}</td>
                            <td>{{ $page['project_code'] }}</td>
                            <td>{{ $page['department_name'] }}</td>
                            <td>{{ date("F j, Y, g:i a", strtotime($page['created_at'])); }}</td>
                            <td>{{ $page['description'] }}</td>
                            <td>{{ $page['duration'] }}</td>
                            <td class="text-center">
                              @if ($page['status'] == 'pending')
                                <span class="badge badge-warning">Pending</span>
                              @elseif ($page['status'] == 'closed')
                                <span class="badge badge-success">Closed</span>
                              @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ url('admin/hazard-show-closed/'.$page['id'])}}"><i class="fas fa-eye text-info" title="Show"></i></a>
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


