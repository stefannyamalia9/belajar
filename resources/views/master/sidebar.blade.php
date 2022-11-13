<nav class="sidebar">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        Dashboard
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
    @if (session()->has('roles_nama'))
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>


        @if (hakAksesMenu('manpower','read') || hakAksesMenu('outlet','read'))
            <li class="nav-item nav-category">Data Master</li>

            @if (hakAksesMenu('manpower','read'))
            <li class="nav-item @yield('manpower')">
                <a href="{{ url('/manpower') }}" class="nav-link">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Manpower</span>
                </a>
            </li>
            @endif
        @endif


      </ul>
    @endif
    </div>
</nav>
