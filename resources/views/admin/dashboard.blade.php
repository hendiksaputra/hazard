@extends('admin.layout.layout')

@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if(Session::has('error_message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error:</strong> {{ Session::get('error_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">
                   <a href=" {{ url('admin/subadmins') }}">Total Users</a> 
                  </span>
                  <span class="info-box-number">
                  {{ $totalAdmin }}
                  {{-- <small>%</small> --}}
                  </span>
                </div> 
            </div>
            
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-th-large"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">
                <a href=" {{ url('admin/hazard-closed-index') }}">Hazard Report</a>  
                </span>
                <span class="info-box-number">{{ $totalHazards }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wind"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">
                <a href=" {{ url('admin/danger-types') }}">Danger Types</a>  
                </span>
                <span class="info-box-number">{{ $totalDangerTypes }}</span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">
                <a href="{{ url('admin/departments')}}">Departments</a> 
                </span>
                <span class="info-box-number">{{ $totalDepartments }}</span>
              </div>
            </div>
          </div>
        </div> 

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

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
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong><?php echo date('d F Y'); ?></strong>
                    </p>
                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="monthlyHazardChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Goal Completion</strong>
                    </p>    
                    <div class="progress-group">
                      Hazard Report <small>( Closed )</small>
                      <span class="float-right">
                        <b>{{ $totalHazardClosed }} ({{ number_format($percentageClosed, 2) }}%)</b>
                      </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: {{ $percentageClosed }}%"></div>
                      </div>
                    </div>
                    <div class="progress-group">
                      Hazard Report <small>( Pending )</small>
                      <span class="float-right">
                        <b>{{ $totalHazardPending }} ({{ number_format($percentagePending, 2) }}%)</b>
                      </span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: {{ $percentagePending }}%"></div>
                      </div>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div>
      </div>
    </section>

    
 
  </div>
@endsection



<script>
document.addEventListener("DOMContentLoaded", function() {
  // Data for the chart
  const monthlyData = @json($monthlyData);

  // Create the chart
  const ctx = document.getElementById('monthlyHazardChart').getContext('2d');
  new Chart(ctx, {
      type: 'bar', // Use 'line' for a line chart
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [{
              label: 'Closed Hazard Reports',
              data: monthlyData,
              backgroundColor: 'rgba(54, 162, 235, 0.5)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          scales: {
              y: {
                  beginAtZero: true,
                  title: {
                      display: true,
                      text: 'Number of Reports'
                  }
              },
              x: {
                  title: {
                      display: true,
                      text: 'Month'
                  }
              }
          }
      }
  });
});

</script>


