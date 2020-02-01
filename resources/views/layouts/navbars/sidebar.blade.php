<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      Flash!
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <!-- todo: if we are logged in as a real user -->
      <li class="nav-item{{ $activePage == 'courses' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('courses.browse') }}">
          <i class="material-icons">courses</i>
          <p>Manage Courses</p>
        </a>
      </li>





    </ul>
  </div>
</div>