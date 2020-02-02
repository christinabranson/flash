<div class="sidebar" data-color="orange" data-background-color="white" data-image="">
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      Flash!
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">home</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'courses' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('courses.browse') }}">
          <i class="material-icons">edit</i>
          <p>Manage Courses</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'history' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('history.index') }}">
          <i class="material-icons">history</i>
          <p>History</p>
        </a>
      </li>




    </ul>
  </div>
</div>