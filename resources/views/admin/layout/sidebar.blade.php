<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ url('admin/images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Hazard Report</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('admin/images/programmer.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name  }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if(Session::get('page') == "dashboard")
            @php $active = "active"; @endphp
          @else
            @php $active = ""; @endphp
          @endif

            <li class="nav-item">
            <a href="{{ url('admin/dashboard') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if(Auth::guard('admin')->user()->type=="admin")

            @if(Session::get('page') == "update-password" || Session::get('page') == "update-details")
              @php $active = "active"; @endphp
            @else
              @php $active = ""; @endphp
            @endif

            <li class="nav-item menu-open">
              <a href="#" class="nav-link {{$active}}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Settings
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                  @if(Session::get('page') == "update-password")
                    @php $active = "active"; @endphp
                  @else
                    @php $active = ""; @endphp
                  @endif
                <li class="nav-item">
                  <a href="{{ url('admin/update-password') }}" class="nav-link {{$active}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update Admin Pass</p>
                  </a>
                </li>
                  @if(Session::get('page') == "update-details")
                    @php $active = "active"; @endphp
                  @else
                    @php $active = ""; @endphp
                  @endif
                <li class="nav-item">
                  <a href="{{ url('admin/update-details') }}" class="nav-link {{$active}}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Update Admin Detail</p>
                  </a>
                </li>
              </ul>
            </li>
            @if(Session::get('page') == "subadmins")
            @php $active = "active"; @endphp
            @else
              @php $active = ""; @endphp
            @endif
            <li class="nav-item">
              <a href="{{ url('admin/subadmins') }}" class="nav-link {{$active}}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users            
                </p>
              </a>
            </li>
            
         


          @if(Session::get('page') == "departments")
              @php $active = "active"; @endphp
            @else
              @php $active = ""; @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/departments') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Departments            
              </p>
            </a>
          </li>

          @if(Session::get('page') == "positions")
              @php $active = "active"; @endphp
            @else
              @php $active = ""; @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/positions') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-project-diagram"></i>
              <p>
                Positions            
              </p>
            </a>
          </li>

          @if(Session::get('page') == "danger-types")
            @php $active = "active"; @endphp
          @else
            @php $active = ""; @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/danger-types') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-shield-virus"></i>
              <p>
                Danger Types             
              </p>
            </a>
          </li>
          @endif 
          
          
          @if(Session::get('page') == "hazard-reports")
          @php $active = "active"; @endphp
          @else
            @php $active = ""; @endphp
          @endif
          <li class="nav-item">
            <a href="{{ url('admin/hazard-reports') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-biohazard"></i>
              <p>
                Hazard Reports             
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('admin/logout') }}" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout           
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>