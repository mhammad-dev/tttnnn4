<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
  
    @if(Auth::user()->scheme_type == 2)
    <h4 id="header-heading">Group Scheme Dashboard</h4>
    @else
    <h4 id="header-heading">Member Dashboard</h4>
    @endif
    

    <ul class="navbar-nav">
      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          @if(!empty(Auth::user()->profile_img_path))
          <img src="{{ url(Auth::user()->profile_img_path) }}" alt="profile">
          @else
          <img src="{{ url('https://via.placeholder.com/30x30') }}">
          @endif

        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
          <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
              @if(!empty(Auth::user()->profile_img_path))
                <img src="{{ url(Auth::user()->profile_img_path) }}" alt="profile">
              @else
                <img src="{{ url('https://via.placeholder.com/80x80') }}">
              @endif
            </div>
            <div class="info text-center">
              <p class="name font-weight-bold mb-0">{{Auth::user()->name}}</p>
              <p class="email text-muted mb-3">{{Auth::user()->email}}</p>
            </div>
          </div>
          <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
              <li class="nav-item">
                <a href="{{ url('/changepassword') }}" class="nav-link">
                  <i data-feather="user"></i>
                  <span>Change Password</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/editprofile') }}" class="nav-link">
                  <i data-feather="edit"></i>
                  <span>Edit Profile</span>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="javascript:;" class="nav-link">
                  <i data-feather="repeat"></i>
                  <span>Switch User</span>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="nav-link">
                  <i data-feather="log-out" class="text-danger"></i>
                  <span class="text-danger">{{ __('Logout') }}</span>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                    </form>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>